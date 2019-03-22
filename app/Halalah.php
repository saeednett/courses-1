<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Halalah extends Model
{
    protected $guarded = [];

    public function center(){
        return $this->belongsTo('App\Center');
    }
}
