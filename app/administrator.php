<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class administrator extends Model
{

    protected $guarded = [];

    public function user(){
        return $this->belongsTo('App/User');
    }

    public function role(){
        return $this->belongsTo('App/Role');
    }

}
