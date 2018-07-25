<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Models\Role;
use App\Models\Menu;
use App\Models\Permission;
use App\Models\PermissionRole;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    private $current_url;
    private $page_title;

    public function __construct()
    {
        $this->current_url = url('/setting/roles');
        $this->page_title = 'Pengaturan Peran dan Akses';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $r)
    {
        /* get data */
        $roles = Role::select(sequence(), 'id', 'display_name as name', 'description', 'status')->get();

        /* set variable for view */
        $data = [
            'current_url' => $this->current_url,
            'page_title' => $this->page_title,
            'page_subtitle' => 'Daftar Peran',
            'data' => $roles,
        ];

        /* generate datatable */
        if ($r->ajax()) {
            return $this->generateDataTable($r, $roles);
        }

        return view('admin.setting.role', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /* set variable for view */
        $data = [
            'current_url' => $this->current_url,
            'page_title' => $this->page_title,
            'page_subtitle' => 'Tambah Peran',
            'menus' => Menu::where('status', 1)->get(),
        ];

        return view('admin.setting.role_form', $data);
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
        $role = new Role;
        $role->name = str_slug($r->input('name'));
        $role->display_name = $r->input('name');
        $role->description = $r->input('description');
        $role->status = $r->input('status') ? 1 : 0;
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
        /* set variable for view */
        $data = [
            'current_url' => $this->current_url,
            'page_title' => $this->page_title,
            'page_subtitle' => 'Edit Peran',
            'data' => $role,
            'menus' => Menu::where('status', 1)->get(),
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
        $role->name = str_slug($r->input('name'));
        $role->display_name = $r->input('name');
        $role->description = $r->input('description');
        $role->status = $r->input('status') ? 1 : 0;
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
