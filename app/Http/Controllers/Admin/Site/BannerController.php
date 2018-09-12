<?php

namespace App\Http\Controllers\Admin\Site;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends AdminController
{
    private $current_url;
    private $page_title;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->current_url = url('/admin/site/banners');
        $this->page_title = 'Pengaturan Spanduk';
        $this->breadcrumbs[] = [
            'page' => 'Spanduk',
            'icon' => '',
            'url' => $this->current_url,
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /* set variable for view */
        $data = [
            'current_url' => $this->current_url,
            'page_title' => $this->page_title,
            'page_subtitle' => 'Daftar Spanduk',
        ];

        return view('admin.site.banner', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /* get data */
        $banners = Banner::orderBy('order')->get();

        /* set variable for view */
        $data = [
            'current_url' => $this->current_url,
            'page_title' => $this->page_title,
            'page_subtitle' => 'Tambah Spanduk',
            'banners' => $banners,
        ];

        return view('admin.site.banner_form', $data);
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
        if ($r->input('only_image')) {
            $validate = [
                'image' => 'mimes:jpg,jpeg,png,svg|max:200|dimensions:max_width=500,max_height=500',
            ];
        } else {
            $validate = [
                'title' => 'required',
                'description' => 'required',
                'image' => 'mimes:jpg,jpeg,png,svg|max:200|dimensions:max_width=500,max_height=500',
            ];
        }
        $this->validate($r, $validate);

        /* save data */
        $banner = new Banner;
        $banner->title = str_sanitize($r->input('title'));
        $banner->description = str_sanitize($r->input('description'));
        $banner->url = str_sanitize($r->input('url'));
        $banner->url_external = bool($r->input('url_external')) ? 1 : 0;
        $banner->target = str_sanitize($r->input('target'));
        $banner->order = $order;
        $banner->only_image = bool($r->input('only_image')) ? 1 : 0;
        $banner->status = bool($r->input('status')) ? 1 : 0;
        $banner->save();

        /* set order */
        $order = 1;
        if ($r->input('order') == 'first') {

        } else {

        }

        /* upload image */
        if ($r->hasFile('image')) {
            $file = $r->file('image');
            $par = [
                'file' => $file,
                'folder' => '/images/banner/',
                'name' => str_slug($file->getClientOriginalName()),
                'type' => $file->getMimeType(),
                'ext' => $file->getClientOriginalExtension(),
            ];

            if ($this->uploadImage($par)) {
                $banner->image = $par['name'] . '.' . $par['ext'];
                $banner->save();
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function show(Banner $banner)
    {
        abort(403);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function edit(Banner $banner)
    {
        /* set variable for view */
        $data = [
            'current_url' => $this->current_url,
            'page_title' => $this->page_title,
            'page_subtitle' => 'Sunting Spanduk',
            'data' => $banner
        ];

        return view('admin.site.banner_form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $r
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $r, Banner $banner)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Banner $banner)
    {
        /* log aktifitas */
        $this->activityLog('<b>' . \Auth::user()->fullname . '</b> menghapus Spanduk "' . $banner->title . '"');

        /* soft delete */
        $banner->delete();

        return redirect($this->current_url)->with('success', 'Spanduk berhasil dihapus!');
    }

    /**
     * Generate DataTables
     */
    public function datatable(Request $r)
    {
        /* get data */
        $data = Banner::select(sequence(), 'id', 'title', 'description', 'image', 'status')->get();

        /* generate datatable */
        if ($r->ajax()) {
            return $this->generateDataTable($r, $data);
        }

        abort(403);
    }
}
