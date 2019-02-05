<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseTrainer extends Model
{
    protected $guarded = [];
    public function course(){
        return $this->hasMany('App\Course');
    }

    public function trainer(){
        return $this->hasMany('App\Trainer');
    }
}
