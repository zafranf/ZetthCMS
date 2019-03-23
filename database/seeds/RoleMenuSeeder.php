<?php

use Illuminate\Database\Seeder;

class RoleMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = \App\Models\Role::all();
        foreach ($roles as $role) {
            if ($role->id == 1) {
                $menus = \App\Models\MenuGroup::all();
                foreach ($menus as $menu) {
                    \App\Models\RoleMenu::create([
                        'role_id' => $role->id,
                        'menu_group_id' => $menu->id,
                    ]);
                }
            }
        }
    }
}
