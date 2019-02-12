<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentConfirmation extends Model
{
    protected $guarded = [];
    protected $table = 'payments_confirmation';

    public function appointment(){
        return $this->belongsTo('App\Reservation');
    }
}
