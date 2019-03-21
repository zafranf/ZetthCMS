<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Menu;
use App\Models\MenuGroup;
use Illuminate\Http\Request;

class MenuController extends AdminController
{
    private $current_url;
    private $page_title;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->current_url = url($this->adminPath . '/setting/application');
        $this->page_title = 'Pengaturan Menu';
        $this->breadcrumbs[] = [
            'page' => 'Pengaturan',
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
            'page' => 'Menu',
            'icon' => '',
            'url' => '',
        ];

        /* set variable for view */
        $data = [
            'current_url' => $this->current_url,
            'page_title' => $this->page_title,
            'page_subtitle' => 'Daftar Menu',
            'menus' => Menu::all(),
            'breadcrumbs' => $this->breadcrumbs,
        ];

        return view('admin.AdminSC.setting.menu', $data);
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
            'page_subtitle' => 'Tambah Menu',
            'menus' => Menu::where('parent_id', 0)->with('allSubmenu')->orderBy('order')->get(),
        ];

        return view('admin.setting.menu_form', $data);
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
        $menu = new Menu;
        $menu->name = str_sanitize($r->input('name'));
        $menu->description = str_sanitize($r->input('description'));
        // $menu->url = $r->input('url');
        $menu->route_name = str_sanitize($r->input('route_name'));
        $menu->target = str_sanitize($r->input('target'));
        // $menu->order = (int) $r->input('order');
        $menu->icon = str_sanitize($r->input('icon'));
        $menu->status = bool($r->input('status')) ? 1 : 0;
        $menu->index = bool($r->input('index')) ? 1 : 0;
        $menu->create = bool($r->input('create')) ? 1 : 0;
        $menu->read = bool($r->input('read')) ? 1 : 0;
        $menu->update = bool($r->input('update')) ? 1 : 0;
        $menu->delete = bool($r->input('delete')) ? 1 : 0;
        $menu->parent_id = (int) $r->input('parent');
        $menu->save();

        /* log aktifitas */
        $this->activityLog('<b>' . \Auth::user()->fullname . '</b> menambahkan Menu "' . $menu->name . '"');

        /* clear cache */
        \Cache::flush();

        return redirect($this->current_url)->with('success', 'Menu berhasil ditambah!');
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
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu)
    {
        /* set variable for view */
        $data = [
            'current_url' => $this->current_url,
            'page_title' => $this->page_title,
            'page_subtitle' => 'Sunting Menu',
            'menus' => Menu::where('parent_id', 0)->with('allSubmenu')->orderBy('order')->get(),
            'data' => $menu,
        ];

        return view('admin.setting.menu_form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $r
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $r, Menu $menu)
    {
        /* validation */
        $this->validate($r, [
            'name' => 'required',
        ]);

        /* save data */
        $menu->name = str_sanitize($r->input('name'));
        $menu->description = str_sanitize($r->input('description'));
        // $menu->url = $r->input('url');
        $menu->route_name = str_sanitize($r->input('route_name'));
        $menu->target = str_sanitize($r->input('target'));
        // $menu->order = (int) $r->input('order');
        $menu->icon = str_sanitize($r->input('icon'));
        $menu->status = bool($r->input('status')) ? 1 : 0;
        $menu->index = bool($r->input('index')) ? 1 : 0;
        $menu->create = bool($r->input('create')) ? 1 : 0;
        $menu->read = bool($r->input('read')) ? 1 : 0;
        $menu->update = bool($r->input('update')) ? 1 : 0;
        $menu->delete = bool($r->input('delete')) ? 1 : 0;
        $menu->parent_id = (int) $r->input('parent');
        $menu->save();

        /* log aktifitas */
        $this->activityLog('<b>' . \Auth::user()->fullname . '</b> memperbarui Menu "' . $menu->name . '"');

        /* clear cache */
        \Cache::flush();

        return redirect($this->current_url)->with('success', 'Menu berhasil disimpan!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $r, Menu $menu)
    {
        /* log aktifitas */
        $this->activityLog('<b>' . \Auth::user()->fullname . '</b> menghapus Menu "' . $menu->name . '"');

        /* soft delete */
        $menu->delete();

        /* clear cache */
        \Cache::flush();

        return redirect($this->current_url)->with('success', 'Menu berhasil dihapus!');
    }

    /**
     * Generate DataTables
     */
    public function datatable(Request $r)
    {
        /* get data */
        $data = MenuGroup::select(sequence(), 'id', 'name', 'description', 'status')->get();

        /* generate datatable */
        if ($r->ajax()) {
            return $this->generateDataTable($r, $data);
        }

        abort(403);
    }

    /**
     * Menu Sort Form
     */
    public function sort(Request $r)
    {
        /* get data */
        $menus = Menu::where('parent_id', 0)->with('allSubmenu')->orderBy('order')->get();

        /* set variable for view */
        $data = [
            'current_url' => $this->current_url,
            'page_title' => $this->page_title,
            'page_subtitle' => 'Urutkan Menu',
            'data' => $menus,
        ];

        return view('admin.setting.menu_sort', $data);
    }

    /* Save Sorted Menu */
    public function sortSave(Request $r, $data = [], $parent = 0)
    {
        /* validation */
        $this->validate($r, [
            'sort' => 'required',
        ]);

        /* save position */
        $save = $this->sortQuery($r);

        /* clear cache */
        \Cache::flush();

        return redirect($this->current_url)->with('success', 'Menu berhasil diurutkan!');
    }

    /* Do Save Menu */
    public function sortQuery(Request $r, $data = [], $parent = 0)
    {
        /* mapping values */
        $updates = [];
        $sorts = empty($data) ? json_decode($r->input('sort'))[0] : $data;
        foreach ($sorts as $order => $sort) {
            $updates[] = Menu::where('id', $sort->id)->update([
                'order' => ($order + 1),
                'parent_id' => $parent,
            ]);
            if (count($sort->children) > 0) {
                foreach ($sort->children as $child) {
                    if (!empty($child)) {
                        $updates = array_merge($updates, $this->sortQuery($r, $child, $sort->id));
                    }
                }
            }
        }

        return $updates;
    }
}
