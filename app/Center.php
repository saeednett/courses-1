<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Center extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function course()
    {
        return $this->hasMany('App\Course');
    }

    public function city()
    {
        return $this->belongsTo('App\City');
    }

    public function trainer()
    {
        return $this->hasMany('App\Trainer');
    }
}
