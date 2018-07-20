<?php

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* menu dashboard */
        $dash = new Menu;
        $dash->name = 'Beranda';
        $dash->description = 'Halaman utama aplikasi';
        $dash->route_name = 'dashboard';
        $dash->target = '_self';
        $dash->order = 1;
        $dash->status = 1;
        $dash->index = 1;
        $dash->save();

        /* menu pengaturan (grup) */
        $set = new Menu;
        $set->name = 'Pengaturan';
        $set->description = 'Grup menu pegaturan';
        $set->order = 2;
        $set->status = 1;
        $set->save();

        /* menu aplikasi */
        $setApl = new Menu;
        $setApl->name = 'Aplikasi';
        $setApl->description = 'Menu pengaturan aplikasi';
        $setApl->route_name = 'application';
        $setApl->order = 1;
        $setApl->status = 1;
        $setApl->parent_id = $set->id;
        $setApl->index = 1;
        $setApl->create = 1;
        $setApl->read = 1;
        $setApl->update = 1;
        $setApl->delete = 1;
        $setApl->save();
        
        /* menu menu */
        $setMenu = new Menu;
        $setMenu->name = 'Menu';
        $setMenu->description = 'Menu pengaturan menu';
        $setMenu->route_name = 'menus';
        $setMenu->order = 2;
        $setMenu->status = 1;
        $setMenu->parent_id = $set->id;
        $setMenu->index = 1;
        $setMenu->create = 1;
        $setMenu->read = 1;
        $setMenu->update = 1;
        $setMenu->delete = 1;
        $setMenu->save();
        
        /* menu peran */
        $setRole = new Menu;
        $setRole->name = 'Peran dan Akses';
        $setRole->description = 'Menu pengaturan peran dan akses';
        $setRole->route_name = 'roles';
        $setRole->order = 3;
        $setRole->status = 1;
        $setRole->parent_id = $set->id;
        $setRole->index = 1;
        $setRole->create = 1;
        $setRole->read = 1;
        $setRole->update = 1;
        $setRole->delete = 1;
        $setRole->save();
        
        /* menu pengguna */
        $setUser = new Menu;
        $setUser->name = 'Pengguna';
        $setUser->description = 'Menu pengaturan pengguna';
        $setUser->route_name = 'users';
        $setUser->order = 4;
        $setUser->status = 1;
        $setUser->parent_id = $set->id;
        $setUser->index = 1;
        $setUser->create = 1;
        $setUser->read = 1;
        $setUser->update = 1;
        $setUser->delete = 1;
        $setUser->save();
    }
}
