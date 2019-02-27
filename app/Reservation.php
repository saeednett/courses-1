<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $guarded = [];

    public function student()
    {
        return $this->belongsTo('App\Student');
    }

    public function appointment()
    {
        return $this->belongsTo('App\Appointment');
    }

    public function payment()
    {
        return $this->hasOne('App\PaymentConfirmation');
    }

    public function coupon()
    {
        return $this->belongsTo('App\Coupon');
    }
}
