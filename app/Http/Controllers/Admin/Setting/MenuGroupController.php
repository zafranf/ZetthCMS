<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Menu;
use App\Models\MenuGroup;
use Illuminate\Http\Request;

class MenuGroupController extends AdminController
{
    private $current_url;
    private $page_title;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->current_url = url($this->adminPath . '/setting/menu-groups');
        $this->page_title = 'Pengaturan Grup Menu';
        $this->breadcrumbs[] = [
            'page' => 'Pengaturan',
            'icon' => '',
            'url' => url($this->adminPath . '/setting/application'),
        ];
        $this->breadcrumbs[] = [
            'page' => 'Menu',
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
            'page_subtitle' => 'Daftar Grup Menu',
            'breadcrumbs' => $this->breadcrumbs,
        ];

        return view('admin.AdminSC.setting.menu_group', $data);
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

        /* set variable for view */
        $data = [
            'current_url' => $this->current_url,
            'page_title' => $this->page_title,
            'page_subtitle' => 'Tambah Grup Menu',
            'breadcrumbs' => $this->breadcrumbs,
        ];

        return view('admin.AdminSC.setting.menu_group_form', $data);
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
        $menu = new MenuGroup;
        $menu->name = str_sanitize($r->input('name'));
        $menu->description = str_sanitize($r->input('description'));
        $menu->status = bool($r->input('status')) ? 1 : 0;
        $menu->save();

        /* activity log */
        $this->activityLog('<b>' . \Auth::user()->fullname . '</b> menambahkan Grup Menu "' . $menu->name . '"');

        return redirect($this->current_url)->with('success', 'Grup Menu berhasil ditambah!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu)
    {
        abort(403);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MenuGroup  $menugroup
     * @return \Illuminate\Http\Response
     */
    public function edit(MenuGroup $menugroup)
    {
        $this->breadcrumbs[] = [
            'page' => 'Edit',
            'icon' => '',
            'url' => '',
        ];

        /* set variable for view */
        $data = [
            'current_url' => $this->current_url,
            'page_title' => $this->page_title,
            'page_subtitle' => 'Edit Grup Menu',
            'breadcrumbs' => $this->breadcrumbs,
            'data' => $menugroup,
        ];

        return view('admin.AdminSC.setting.menu_group_form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $r
     * @param  \App\Models\MenuGroup  $menugroup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $r, $menugroup)
    {
        /* validation */
        $this->validate($r, [
            'name' => 'required',
        ]);

        /* save data */
        // $menugroup = MenuGroup::find($id);
        $menugroup->name = str_sanitize($r->input('name'));
        $menugroup->description = str_sanitize($r->input('description'));
        $menugroup->status = bool($r->input('status')) ? 1 : 0;
        $menugroup->save();

        /* activity log */
        $this->activityLog('<b>' . \Auth::user()->fullname . '</b> memperbarui Grup Menu "' . $menugroup->name . '"');

        /* clear cache */
        \Cache::forget('cacheMenu-Group' . ucfirst($menugroup->name));

        return redirect($this->current_url)->with('success', 'Grup Menu berhasil disimpan!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MenuGroup  $menugroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $r, $menugroup)
    {
        /* get data */
        // $menugroup = MenuGroup::find($id);

        /* activity log */
        $this->activityLog('<b>' . \Auth::user()->fullname . '</b> menghapus Grup Menu "' . $menugroup->name . '"');

        /* delete data */
        $menugroup->delete();

        /* clear cache */
        \Cache::forget('cacheMenu-Group' . ucfirst($menugroup->name));

        return redirect($this->current_url)->with('success', 'Grup Menu berhasil dihapus!');
    }

    /**
     * Generate DataTables
     */
    public function datatable(Request $r)
    {
        /* get data */
        $data = MenuGroup::select('id', 'name', 'description', 'status')->get();

        /* generate datatable */
        if ($r->ajax()) {
            return $this->generateDataTable($r, $data);
        }

        abort(403);
    }
}
