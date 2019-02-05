<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
    protected $guarded = [];

    public function student()
    {
        return $this->hasMany('App\Student');
    }
}
