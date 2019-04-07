<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'username', 'phone', 'password', 'role_id', 'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function administrator()
    {
        return $this->hasOne('App\Administrator');
    }

    public function student()
    {
        return $this->hasOne('App\Student');
    }

    public function center()
    {
        return $this->hasOne('App\Center');
    }

    public function admin()
    {
        return $this->hasOne('App\Admin');
    }

    public function trainer()
    {
        return $this->hasOne('App\Trainer');
    }

    public function role()
    {
        return $this->belongsTo('App\Role');
    }


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }


    public function getJWTCustomClaims()
    {
        return [];
    }
}
