<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $guarded = [];

    public function center()
    {
        return $this->hasManyThrough('App\Center','App\City');
    }

    public function city()
    {
        return $this->hasMany('App\City');
    }
}
