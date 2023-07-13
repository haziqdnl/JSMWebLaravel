<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     *  DB settings
     */
    protected $table = 'tb_user';
    protected $primaryKey = 'uuid';
    
    /**
     *  Model attributes
     */
    protected $fillable = [
        'uuid',
        'email',
        'email_verified_at',    // null = not verified
        'password',
        'otp',
        'otp_expired_at',
        'token',
        'token_expired_at',
        'login_at',
        'created_at',
        'updated_at',
        'suspend',              // 0 = Active; 1 = Suspend
        'profile_id',
        'profile_type',
    ];

    /**
     *  Hide attributes from showing in JSON
     */
    protected $hidden = [
        'password',
        'profile_id',
        'profile_type',
    ];

    /**
     *  Casting datatype
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'otp_expired_at' => 'datetime',
        'token_expired_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     *  Polymorphism relationship between Staff and User table
     */
    protected $with = ['profile'];
    public function profile() {
        return $this->morphTo();
    }
}
