<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Menu;
use App\Models\Permission;
use App\Models\PermissionRole;
use App\Models\Role;
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
            'page' => 'Daftar',
            'icon' => '',
            'url' => '',
        ];

        /* set variable for view */
        $data = [
            'current_url' => $this->current_url,
            'page_title' => $this->page_title,
            'page_subtitle' => 'Daftar Peran',
            'breadcrumbs' => $this->breadcrumbs,
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

        /* get data */
        $menus = Menu::where([
            'parent_id' => 0,
            'status' => 1,
        ])->with('submenu')->orderBy('order')->get();

        /* set variable for view */
        $data = [
            'current_url' => $this->current_url,
            'page_title' => $this->page_title,
            'page_subtitle' => 'Tambah Peran',
            'menus' => $menus,
            'breadcrumbs' => $this->breadcrumbs,
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
            'name' => 'required',
        ]);

        /* save data */
        $name = str_sanitize($r->input('name'));
        $role = new Role;
        $role->name = str_slug($name);
        $role->display_name = $name;
        $role->description = str_sanitize($r->input('description'));
        $role->status = bool($r->input('status')) ? 1 : 0;
        $role->save();

        /* set permissions */
        $this->setPermissions($r, $role);

        /* log aktifitas */
        $this->activityLog('<b>' . \Auth::user()->fullname . '</b> menambahkan Peran "' . $role->display_name . '"');

        return redirect('/setting/roles')->with('success', 'Peran berhasil ditambah!');
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
        /* get data */
        $menus = Menu::where([
            'parent_id' => 0,
            'status' => 1,
        ])->with('submenu')->orderBy('order')->get();

        /* set variable for view */
        $data = [
            'current_url' => $this->current_url,
            'page_title' => $this->page_title,
            'page_subtitle' => 'Sunting Peran',
            'data' => $role,
            'menus' => $menus,
        ];

        return view('admin.setting.role_form', $data);
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
            'name' => 'required',
        ]);

        /* save data */
        $name = str_sanitize($r->input('name'));
        $role->name = str_slug($name);
        $role->display_name = $name;
        $role->description = str_sanitize($r->input('description'));
        $role->status = bool($r->input('status')) ? 1 : 0;
        $role->save();

        /* set permissions */
        $this->setPermissions($r, $role);

        /* log aktifitas */
        $this->activityLog('<b>' . \Auth::user()->fullname . '</b> memperbarui Peran "' . $role->name . '"');

        return redirect('/setting/roles')->with('success', 'Peran berhasil disimpan!');
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
        $this->activityLog('<b>' . \Auth::user()->fullname . '</b> menghapus Peran "' . $role->name . '"');

        /* soft delete */
        $role->delete();

        return redirect('/setting/roles')->with('success', 'Peran berhasil dihapus!');
    }

    /**
     * Generate DataTables
     */
    public function datatable(Request $r)
    {
        /* get data */
        $data = Role::select(sequence(), 'id', 'display_name as name', 'description', 'status')->get();

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
        PermissionRole::where('role_id', $role->id)->delete();

        /* attach new permissions */
        $permissions = [];
        $accesses = $r->input('access');
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
}
