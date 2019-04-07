<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trainer extends Model
{
    public $guarded = [];

    public function course(){
        return $this->hasMany('App\CourseTrainer');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function nationality(){
        return $this->belongsTo('App\Nationality');
    }

    public function title(){
        return $this->belongsTo('App\Title');
    }

    public function center(){
        return $this->belongsTo('App\Center');
    }

}
