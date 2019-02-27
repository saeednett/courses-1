<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $guarded = [];


    public function image()
    {
        return $this->hasMany('App\Image');
    }

    public function center()
    {
        return $this->belongsTo('App\Center');
    }

    public function city()
    {
        return $this->belongsTo('App\City');
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

    public function template()
    {
        return $this->hasOne('App\Template');
    }

    public function trainer()
    {
        return $this->hasMany('App\CourseTrainer');
    }

    public function admin()
    {
        return $this->hasMany('App\CourseAdmin');
    }

    public function appointment()
    {
        return $this->hasOne('App\Appointment');
    }

    public function coupon()
    {
        return $this->hasMany('App\Coupon');
    }

}
