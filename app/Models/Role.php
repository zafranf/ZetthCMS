<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Laratrust\Models\LaratrustRole;

class Role extends LaratrustRole
{
    use SoftDeletes;

    public function menu_groups()
    {
        return $this->belongsToMany('App\Models\MenuGroup', 'role_menu', 'role_id', 'menu_group_id');
    }

    public function getMenusAttribute($value)
    {
        $menugroups = $this->menu_groups;

        // There two calls return collections
        // as defined in relations.
        $competitionsHome = $this->competitionsHome;
        $competitionsGuest = $this->competitionsGuest;

        // Merge collections and return single collection.
        return $competitionsHome->merge($competitionsGuest);
    }

    public function menus()
    {
        $menugroups = $this->menu_groups()->with('menu.submenu')->get();
        $menus = collect([]);
        foreach ($menugroups as $group) {
            $menus = $menus->merge($group->menu);
        }
        dd($menus);

        return $menugroups;
    }
}
