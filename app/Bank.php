<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $guarded = [];

    public function center()
    {
        return $this->hasMany('App\Center');
    }
}
