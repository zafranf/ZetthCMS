<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuGroup extends Model
{
    use SoftDeletes;

    public function menu()
    {
        return $this->hasMany('App\Models\Menu', 'group_id')->where([
            'parent_id' => 0,
            'status' => 1,
        ]);
    }

    public function allMenu()
    {
        return $this->hasMany('App\Models\Menu');
    }
}
