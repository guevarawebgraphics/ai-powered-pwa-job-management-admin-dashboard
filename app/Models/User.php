<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Notifications\CustomerResetPassword;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class User
 * @package App\Models
 * @author Richard Guevara | Monte Carlo Web Graphics
 */
class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    use SoftDeletes;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'user_name',
        'first_name',
        'middle_name',
        'last_name',
        'phone',
        'email',
        'password',
        'profile_photo',
        'service_area',
        'is_verified',
        'otp_code',
        'otp_expires_at',
        'current_ip',
        'mobile_no', 
        'home_no',
        'professional_title',
        'skills',
        'current_address',
        'is_notify',
        'is_location',
        'is_active'

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /**
     * Override and make all passwords encrypted.
     *
     * @param  string $password
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    /**
     * Send the password reset notification.
     *
     * @param  string $token
     *
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $user = $this;
        $this->notify(new CustomerResetPassword($token, $user));
    }


    public function chatsToMe()
    {
        return $this->hasMany('App\Models\Chat', 'from_user_id', 'id');
    }
}
