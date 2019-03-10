<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $guarded = [];


    public function image()
    {
        return $this->hasOne('App\Image');
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

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function trainer()
    {
        return $this->hasMany('App\CourseTrainer');
    }

    public function admin()
    {
        return $this->hasMany('App\CourseAdmin');
    }

    public function discountCoupon()
    {
        return $this->hasMany('App\Coupon');
    }

}
