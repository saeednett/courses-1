<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $guarded = [];

    public function country()
    {
        return $this->belongsTo('App\Country');
    }

    public function center()
    {
        return $this->hasMany('App\Center');
    }

    public function student()
    {
        return $this->hasMany('App\Student');
    }
}
