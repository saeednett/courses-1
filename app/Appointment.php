<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $guarded = [];

    public function course()
    {
        return $this->belongsTo('App\Course');
    }

    public function reservation()
    {
        return $this->hasMany('App\Reservation');
    }
}
