<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SocialMedia extends Model
{
    protected $guarded = [];

    public function center()
    {
        return $this->hasMany('App\CenterSocialMedia');
    }
}
