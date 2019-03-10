<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseTrainer extends Model
{
    protected $guarded = [];
    public function course(){
        return $this->belongsTo('App\Course');
    }

    public function trainer(){
        return $this->belongsTo('App\Trainer');
    }
}
