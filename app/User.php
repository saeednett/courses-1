<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'username', 'phone', 'password', 'role_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

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

    public function course()
    {
        return $this->hasMany('App\CourseAdmin');
    }

    public function trainer()
    {
        return $this->hasMany('App\Trainer', 'center_id');
    }
}
