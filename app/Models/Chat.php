<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Chat
 * @package App\Models
 * @author Richard Guevara | Monte Carlo Web Graphics
 */
class Chat extends Model
{
    use SoftDeletes;

    protected $table = 'chats';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'from_user_id',
        'to_user_id',
        'message',
        'is_seen'
    ];

    public function sender()
    {
        return $this->hasOne('App\Models\User', 'id','from_user_id');
    }

    public function receiver()
    {
        return $this->hasOne('App\Models\User', 'id','to_user_id');
    }

}