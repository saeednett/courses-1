<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function city()
    {
        return $this->belongsTo('App\City');
    }

    public function gender()
    {
        return $this->belongsTo('App\Gender');
    }

    public function reservation()
    {
        return $this->hasMany('App\Reservation');
    }

    public function attendance()
    {
        return $this->hasMany('App\Attendance');
    }

    public function certificate()
    {
        return $this->hasMany('App\Certificate');
    }

}
