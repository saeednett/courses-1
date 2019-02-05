<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Title extends Model
{
    public function trainer(){
        return $this->hasMany('App/Trainer');
    }
}
