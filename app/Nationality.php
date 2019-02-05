<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nationality extends Model
{
    public function trainer(){
        return $this->hasMany('App/Trainer');
    }
}
