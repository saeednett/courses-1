<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseAdmin extends Model
{
    protected $guarded = [];

    public function admin()
    {
        return $this->belongsTo('App\Admin');
    }

    public function course()
    {
        return $this->belongsTo('App\Course');
    }
}
