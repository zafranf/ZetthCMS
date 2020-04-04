<?php

namespace App\Models;

use ZetthCore\Models\User as BaseUser;

class User extends BaseUser
{
    protected $dates = ['verified_at'];

    public function oauths()
    {
        return $this->hasMany('App\Models\UserOauth');
    }
}
