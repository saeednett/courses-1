<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CenterSocialMedia extends Model
{
    protected $guarded = [];

    public function socialMediaInformation()
    {
        return $this->belongsTo('App\SocialMedia', 'id');
    }

    public function center()
    {
        return $this->belongsTo('App\Center');
    }
}
