<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deadline extends Model
{
    protected $guarded = [];

    public function course()
    {
        return $this->hasOne('App\Course');
    }
}
