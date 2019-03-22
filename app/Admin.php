<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function center()
    {
        return $this->belongsTo('App\Center');
    }

    public function course()
    {
        return $this->hasMany('App\CourseAdmin');
    }

    public function certificate()
    {
        return $this->hasMany('App\Certificate');
    }

    public function attendance()
    {
        return $this->hasMany('App\Attendance');
    }

}
