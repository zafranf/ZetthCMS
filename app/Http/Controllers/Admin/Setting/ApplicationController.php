<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationController extends AdminController
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
        $this->page_title = 'Pengaturan Aplikasi';
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
    public function index()
    {
        $this->breadcrumbs[] = [
            'page' => 'Aplikasi',
            'icon' => '',
            'url' => '',
        ];

        $data = [
            'current_url' => $this->current_url,
            'page_title' => $this->page_title,
            'page_subtitle' => 'Aplikasi',
            'data' => Application::find(1),
            'breadcrumbs' => $this->breadcrumbs,
        ];

        return view('admin.AdminSC.setting.application', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort(403);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $r
     * @return \Illuminate\Http\Response
     */
    public function store(Request $r)
    {
        abort(403);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Application  $app
     * @return \Illuminate\Http\Response
     */
    public function show(Application $app)
    {
        abort(403);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Application  $app
     * @return \Illuminate\Http\Response
     */
    public function edit(Application $app)
    {
        abort(403);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $r
     * @param  \App\Models\Application  $app
     * @return \Illuminate\Http\Response
     */
    public function update(Request $r, Application $app)
    {
        /* validation */
        $this->validate($r, [
            'name' => 'required',
            'logo' => 'dimensions:max_height=500,max_width=500|max:512',
        ]);

        /* save data */
        $app->name = str_sanitize($r->input('name'));
        $app->description = str_sanitize($r->input('description'));
        $app->status = bool($r->input('status')) ? 1 : 0;
        $app->save();

        /* upload logo */
        if ($r->hasFile('logo')) {
            $file = $r->file('logo');
            $par = [
                'file' => $file,
                'folder' => '/images/',
                'name' => 'logo',
                'type' => $file->getMimeType(),
                'ext' => $file->getClientOriginalExtension(),
            ];

            if ($this->uploadImage($par)) {
                $app->logo = $par['name'] . '.' . $par['ext'];
                $app->save();
            }
        }

        /* log aktifitas */
        $this->activityLog('<b>' . \Auth::user()->fullname . '</b> memperbarui Pengaturan - Aplikasi');

        return redirect()->back()->with('success', 'Pengaturan Aplikasi berhasil disimpan!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Application  $app
     * @return \Illuminate\Http\Response
     */
    public function destroy(Application $app)
    {
        abort(403);
    }
}
