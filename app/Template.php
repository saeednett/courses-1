<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $guarded = [];

    public function course()
    {
        return $this->hasMany('App\Course');
    }
}
