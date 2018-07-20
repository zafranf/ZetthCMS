<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use SoftDeletes;

    public function submenu()
    {
        return $this->hasMany('App\Models\Menu', 'parent_id', 'id')->where('status', 1)->orderBy('order')->with('submenu');
    }
}
