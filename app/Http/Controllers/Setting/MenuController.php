<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    private $current_url;
    private $page_title;

    public function __construct()
    {
        $this->current_url = url('/setting/menus');
        $this->page_title = 'Pengaturan Menu';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $r)
    {
        /* get data */
        $menus = Menu::select(sequence(), 'id', 'name', 'description', 'status')->get();

        /* set variable for view */
        $data = [
            'current_url' => $this->current_url,
            'page_title' => $this->page_title,
            'page_subtitle' => 'Daftar Menu',
            'data' => $menus,
        ];

        /* generate datatable */
        if ($r->ajax()) {
            return $this->generateDataTable($r, $menus);
        }

        return view('setting.menu', $data);
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
            'menus' => Menu::where('status', 1)->get(),
        ];

        return view('setting.menu_form', $data);
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
        $menu->name = $r->input('name');
        $menu->description = $r->input('description');
        // $menu->url = $r->input('url');
        $menu->route_name = $r->input('route_name');
        $menu->target = $r->input('target');
        $menu->order = $r->input('order');
        $menu->icon = $r->input('icon');
        $menu->status = $r->input('status') ? 1 : 0;
        $menu->index = $r->input('index') ? 1 : 0;
        $menu->create = $r->input('create') ? 1 : 0;
        $menu->read = $r->input('read') ? 1 : 0;
        $menu->update = $r->input('update') ? 1 : 0;
        $menu->delete = $r->input('delete') ? 1 : 0;
        $menu->parent_id = $r->input('parent');
        $menu->save();

        /* log aktifitas */
        $this->activityLog('<b>' . \Auth::user()->fullname . '</b> menambahkan Menu "' . $menu->name . '"');

        return redirect('/setting/menus')->with('success', 'Menu berhasil ditambah!');
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
            'page_subtitle' => 'Edit Menu',
            'menus' => Menu::where('status', 1)->get(),
            'data' => $menu,
        ];

        return view('setting.menu_form', $data);
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
        $menu->name = $r->input('name');
        $menu->description = $r->input('description');
        $menu->url = $r->input('url');
        $menu->route_name = $r->input('route_name');
        $menu->target = $r->input('target');
        $menu->order = $r->input('order');
        $menu->icon = $r->input('icon');
        $menu->status = $r->input('status') ? 1 : 0;
        $menu->index = $r->input('index') ? 1 : 0;
        $menu->create = $r->input('create') ? 1 : 0;
        $menu->read = $r->input('read') ? 1 : 0;
        $menu->update = $r->input('update') ? 1 : 0;
        $menu->delete = $r->input('delete') ? 1 : 0;
        $menu->parent_id = $r->input('parent');
        $menu->save();

        /* log aktifitas */
        $this->activityLog('<b>' . \Auth::user()->fullname . '</b> memperbarui Menu "' . $menu->name . '"');

        return redirect('/setting/menus')->with('success', 'Menu berhasil disimpan!');
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

        return redirect('/setting/menus')->with('success', 'Menu berhasil dihapus!');
    }

    public function sort(Request $r)
    {
        /* get data */
        $menus = Menu::where('parent_id', 0)->with('submenu')->orderBy('order')->get();

        /* set variable for view */
        $data = [
            'current_url' => $this->current_url,
            'page_title' => $this->page_title,
            'page_subtitle' => 'Urutkan Menu',
            'data' => $menus,
        ];

        return view('setting.menu_sort', $data);
    }

    public function sortSave(Request $r, $data = [], $parent = 0)
    {
        /* validation */
        $this->validate($r, [
            'sort' => 'required',
        ]);

        /* save position */
        $save = $this->sortQuery($r);

        return redirect('/setting/menus')->with('success', 'Menu berhasil diurutkan!');
    }

    public function sortQuery(Request $r, $data = [], $parent = 0)
    {
        /* mapping values */
        $updates = [];
        $sort = empty($data) ? json_decode($r->input('sort'))[0] : $data;
        $sorts = $sort;
        foreach ($sorts as $order => $sort) {
            $updates[] = Menu::where('id', $sort->id)->update([
                'order' => ($order + 1),
                'parent_id' => $parent
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
