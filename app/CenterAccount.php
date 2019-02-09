<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CenterAccount extends Model
{
    protected $guarded = [];

    public function center() {
        return $this->belongsTo('App\Center');
    }

    public function bank() {
        return $this->belongsTo('App\Bank');
    }
}
