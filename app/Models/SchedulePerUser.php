<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class SchedulePerUser extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'schedules_per_user';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'open',
        'close',
        'day',
        'user_id',
        'is_close',
    ];

    protected $dates = ['deleted_at'];
}