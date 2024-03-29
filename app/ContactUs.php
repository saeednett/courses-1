<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    protected $guarded = [];

    protected $table = "contact_us";

    public function student(){
        return $this->belongsTo('App\Student');
    }
}
