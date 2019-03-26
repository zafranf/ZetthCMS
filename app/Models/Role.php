<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Laratrust\Models\LaratrustRole;

class Role extends LaratrustRole
{
    use SoftDeletes;

    public function menu_groups()
    {
        return $this->belongsToMany('App\Models\MenuGroup', 'role_menu', 'role_id', 'menu_group_id')->with('menu.submenu');
    }

    /* public function getMenusAttribute($value)
{
// dd($this->menugroups);
// $menugroups = $this->menu_groups()->with('menu.submenu')->get();
$menus = collect([]);
foreach ($this->menugroups as $group) {
$menus = $menus->merge($group->menu);
}

return $menus;
}

public function getMenuGroupsAttribute($value)
{
return $this->menu_groups()->with('menu.submenu')->get();
} */
}
