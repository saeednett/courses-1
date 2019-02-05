<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $guarded = [];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function center(){
        return $this->belongsTo('App\Center');
    }

    public function course(){
        return $this->hasManyThrough('App\CourseAdmin', 'App\User', 'id', 'user_id', 'user_id');
    }

}
