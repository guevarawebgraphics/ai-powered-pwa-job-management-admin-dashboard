<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index($from, $to){
        $fromUserId = $from; // Admin ID
        $toUserId = $to; // User ID

        $query = Chat::with(['sender', 'receiver'])
            ->where(function ($q) use ($fromUserId, $toUserId) {
                $q->where('from_user_id', $fromUserId)->where('to_user_id', $toUserId)
                ->orWhere('from_user_id', $toUserId)->where('to_user_id', $fromUserId);
            })
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'asc') // Ordering from oldest to newest
            ->get();

        return response()->json([
            'message' => 'Successfully retrieved chat history!',
            'data' => $query,
        ], 200);

    }

    public function getChatUsers($id)
    {
        $authUserId = $id; // Ensure the user is authenticated

        if (!$authUserId) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }

        $users = User::withCount([
            'chatsToMe as chat_count_to_me' => function ($query) use ($authUserId) {
                $query->where('to_user_id', $authUserId);
            },
            'chatsToMe as unread_chat_count_to_me' => function ($query) use ($authUserId) {
                $query->where('to_user_id', $authUserId)->where('is_seen', 0);
            }
        ])
        ->whereNull('deleted_at')
        ->orderBy('unread_chat_count_to_me', 'desc') // Sort by unread messages first
        ->orderBy('created_at', 'asc') // Sort by creation date as a fallback
        ->get();

        return response()->json([
            'message' => 'Successfully retrieved chats!',
            'data' => $users,
        ], 201);
    }

}
