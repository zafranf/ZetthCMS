<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Laratrust\Models\LaratrustRole;

class Role extends LaratrustRole
{
    use SoftDeletes;

    public function menu()
    {
        return $this->belongsToMany('App\Models\Menu', 'role_menu', 'role_id', 'menu_id')->where([
            'parent_id' => 0,
            'status' => 1,
        ]);
    }
}
