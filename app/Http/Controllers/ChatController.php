<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use App\Events\ChatSent;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index($from, $to){
        $fromUserId = $from; // Admin ID
        $toUserId = $to; // User ID

        // $query = Chat::with(['sender', 'receiver'])
        //     ->where(function ($q) use ($fromUserId, $toUserId) {
        //         $q->where('from_user_id', $fromUserId)->where('to_user_id', $toUserId)
        //         ->orWhere('from_user_id', $toUserId)->where('to_user_id', $fromUserId);
        //     })
        //     ->whereNull('deleted_at')
        //     ->orderBy('created_at', 'asc') // Ordering from oldest to newest
        //     ->get();

        $query = Chat::with(['sender', 'receiver'])
        ->where(function ($q) use ($fromUserId, $toUserId) {
            $q->where(function ($q1) use ($fromUserId, $toUserId) {
                $q1->where('from_user_id', $fromUserId)->where('to_user_id', $toUserId);
            })->orWhere(function ($q2) use ($fromUserId, $toUserId) {
                $q2->where('from_user_id', $toUserId)->where('to_user_id', $fromUserId);
            });
        })
        ->whereNull('deleted_at')
        ->orderBy('created_at', 'asc')
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

    public function store(Request $request)
    {
        $data = $request->all();
        $user = User::find($data['from_user_id']);
        \Log::info('Manoy');
        \Log::info($data);
        \Log::info('End of Manoy');
        // $data['from_user_id']
        if ($data['role_id'] == 1) {
            $query = User::where('role_id', 0)->whereNull('deleted_at')->orderBy('created_at','DESC')->get();
          
            foreach ( $query ?? [] as $field ) {

                $input = [];
                $input['from_user_id'] = $data['from_user_id'];
                $input['to_user_id'] = $field->id;
                $input['message'] = $data['message'];
                $input['is_seen'] = 0;
                $input['created_at']    =   now();
                $input['updated_at']    =   now();
                $store_query = Chat::create($input);


                     
                $notif_data = [
                    "name" => "New Message",
                    "content" => "A message has been sent you by " . $user->name . " (".$user->email.")." ,
                    "user_id" => $field->id,
                    "type" => 1,
                    "icon_type" => "fa-solid fa-comments"
                ];
                

            }
        } else if ($data['role_id'] == 0) {
            $input = [];
            $input['from_user_id'] = $data['from_user_id'];
            $input['to_user_id'] =  $data['to_user_id'];
            $input['message'] = $data['message'];
            $input['is_seen'] = 0;
            $input['created_at']    =   now();
            $input['updated_at']    =   now();
            $store_query = Chat::create($input);

            $notif_data = [
                "name" => "New Message",
                "content" => "A message has been sent you by " . $user->name . " (".$user->email.")." ,
                "user_id" =>  $data['to_user_id'],
                "type" => 1,
                "icon_type" => "fa-solid fa-comments"
            ];
            

        }
        
        if (config('app.env') == "local") {
            
            // event(new ChatSent($notif_data));
            broadcast(new \App\Events\ChatSent($notif_data));
        }


        return response()->json(['message' => 'Successfully stored!', 'user'    =>  $user ], 201);
    }

}
