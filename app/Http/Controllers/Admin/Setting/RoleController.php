<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Admin\AdminController;
use App\Models\MenuGroup;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RoleMenu;
use App\Models\RolePermission;
use Illuminate\Http\Request;

class RoleController extends AdminController
{
    private $current_url;
    private $page_title;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->current_url = url($this->adminPath . '/setting/roles');
        $this->page_title = 'Pengaturan Peran dan Akses';
        $this->breadcrumbs[] = [
            'page' => 'Pengaturan',
            'icon' => '',
            'url' => url($this->adminPath . '/setting/application'),
        ];
        $this->breadcrumbs[] = [
            'page' => 'Peran dan Akses',
            'icon' => '',
            'url' => $this->current_url,
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $r)
    {
        $this->breadcrumbs[] = [
            'page' => 'Tabel',
            'icon' => '',
            'url' => '',
        ];

        /* set variable for view */
        $data = [
            'current_url' => $this->current_url,
            'breadcrumbs' => $this->breadcrumbs,
            'page_title' => $this->page_title,
            'page_subtitle' => 'Tabel Peran',
        ];

        return view('admin.AdminSC.setting.roles', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->breadcrumbs[] = [
            'page' => 'Tambah',
            'icon' => '',
            'url' => '',
        ];

        /* get data menugroups */
        $menugroups = MenuGroup::where('status', 1)->get();

        /* set variable for view */
        $data = [
            'current_url' => $this->current_url,
            'breadcrumbs' => $this->breadcrumbs,
            'page_title' => $this->page_title,
            'page_subtitle' => 'Tambah Peran',
            'menugroups' => $menugroups,
        ];

        return view('admin.AdminSC.setting.roles_form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $r
     * @return \Illuminate\Http\Response
     */
    public function store(Request $r)
    {
        /* validation */
        $this->validate($r, [
            'name' => 'required|unique:roles',
        ]);

        /* save data */
        $name = $r->input('name');
        $role = new Role;
        $role->name = str_slug($name);
        $role->display_name = $name;
        $role->description = $r->input('description');
        $role->status = bool($r->input('status')) ? 1 : 0;
        $role->save();

        /* set permissions */
        // $this->setPermissions($r, $role);

        /* save menu group */
        $this->saveMenuGroup($r, $role);

        /* log aktifitas */
        $this->activityLog('<b>' . \Auth::user()->fullname . '</b> menambahkan Peran "' . $role->name . '"');

        return redirect($this->current_url . '/' . $role->id . '/edit')->with('success', 'Peran "' . $role->display_name . '" berhasil ditambah, segera atur akses menu!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        abort(403);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $this->breadcrumbs[] = [
            'page' => 'Edit',
            'icon' => '',
            'url' => '',
        ];

        /* get data menugroups */
        $menugroups = MenuGroup::where('status', 1)->get();
        $role = $role->load('menu_groups');

        /* set variable for view */
        $data = [
            'current_url' => $this->current_url,
            'breadcrumbs' => $this->breadcrumbs,
            'page_title' => $this->page_title,
            'page_subtitle' => 'Edit Peran',
            'menugroups' => $menugroups,
            'menus' => $this->roleMenus($role),
            'data' => $role,
        ];

        return view('admin.AdminSC.setting.roles_form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $r
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $r, Role $role)
    {
        /* validation */
        $this->validate($r, [
            'name' => 'required|unique:roles,name,' . $role->id . ',id',
        ]);

        /* save data */
        $name = $r->input('name');
        $role->name = str_slug($name);
        $role->display_name = $name;
        $role->description = $r->input('description');
        $role->status = bool($r->input('status')) ? 1 : 0;
        $role->save();

        /* set permissions */
        if (bool($r->input('is_access'))) {
            $this->setPermissions($r, $role);
        } else {
            /* remove all permissions */
            RolePermission::where('role_id', $role->id)->delete();
        }

        /* save menu group */
        $this->saveMenuGroup($r, $role);

        /* log aktifitas */
        $this->activityLog('<b>' . \Auth::user()->fullname . '</b> memperbarui Peran "' . $role->name . '"');

        return redirect($this->current_url . '/' . $role->id . '/edit')->with('success', 'Peran "' . $role->display_name . '" berhasil disimpan, segera atur akses menu!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        /* log aktifitas */
        $this->activityLog('<b>' . \Auth::user()->fullname . '</b> menghapus Peran "' . $role->display_name . '"');

        /* soft delete */
        $role->delete();

        return redirect($this->current_url)->with('success', 'Peran "' . $role->display_name . '" berhasil dihapus!');
    }

    /**
     * Generate DataTables
     */
    public function datatable(Request $r)
    {
        /* where roles */
        if (\Auth::user()->hasRole('super')) {
            $whrRole = [
                // ['status', 1],
            ];
        } else if (\Auth::user()->hasRole('admin')) {
            $whrRole = [
                // ['status', 1],
                ['id', '!=', 1],
            ];
        } else {
            $whrRole = [
                // ['status', 1],
                ['id', '!=', 1],
                ['id', '!=', 2],
            ];
        }

        /* get data */
        $data = Role::select('id', 'display_name as name', 'description', 'status')->where($whrRole)->get();

        /* generate datatable */
        if ($r->ajax()) {
            return $this->generateDataTable($r, $data);
        }

        abort(403);
    }

    /**
     * Set Permission Role
     */
    public function setPermissions(Request $r, Role $role)
    {
        /* remove all permissions */
        RolePermission::where('role_id', $role->id)->delete();

        /* add menus access */
        $accesses = $r->input('access');
        if (in_array('menu-groups', array_keys($accesses))) {
            $accesses['menus'] = $accesses['menu-groups'];
        }

        /* attach new permissions */
        $permissions = [];
        foreach ($accesses as $module => $access) {
            foreach ($access as $key => $val) {
                // $role->attachPermission($key . '-' . $module);
                $permissions[] = Permission::firstOrCreate([
                    'name' => $key . '-' . $module,
                    'display_name' => ucfirst($key) . ' ' . ucfirst($module),
                    'description' => ucfirst($key) . ' ' . ucfirst($module),
                ])->id;
            }
        }

        // Attach all permissions to the role
        $role->permissions()->sync($permissions);
    }

    public function saveMenuGroup(Request $r, Role $role)
    {
        /* remove all menu group id */
        RoleMenu::where('role_id', $role->id)->delete();

        $menugroups = $r->input('menugroups') ?? [];
        foreach ($menugroups as $group) {
            $rolemenu = new RoleMenu;
            $rolemenu->role_id = $role->id;
            $rolemenu->menu_group_id = $group;
            $rolemenu->save();
        }
    }
}
