<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $guarded = [];

    public function student()
    {
        return $this->belongsTo('App\Student');
    }

    public function admin()
    {
        return $this->belongsTo('App\Admin');
    }

    public function course()
    {
        return $this->belongsTo('App\Course');
    }


    public function reservation(){
        return $this->belongsTo('App\Reservation');
    }

}
