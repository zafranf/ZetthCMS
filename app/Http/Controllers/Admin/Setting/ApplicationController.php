<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Application;
use App\Models\Socmed;
use App\Models\SocmedData;
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

        /* set variable for view */
        $data = [
            'current_url' => $this->current_url,
            'page_title' => $this->page_title,
            'page_subtitle' => 'Aplikasi',
            // 'config' => Application::find(1),
            'breadcrumbs' => $this->breadcrumbs,
        ];

        $data['socmeds'] = Socmed::where('status', 1)->get();
        $data['socmed_data'] = SocmedData::where([
            'type' => 'config',
        ])->with('socmed')->get();

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
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $r, $id)
    {
        /* validation */
        $this->validate($r, [
            'name' => 'required|max:50',
            // 'description' => 'required',
            // 'keyword' => 'required',
            // 'email' => 'required|email',
            'email' => 'email|nullable',
            'logo' => 'dimensions:max_height=512,max_width=512|max:512',
            'icon' => 'dimensions:max_height=64,max_width=64|max:64',
            'perpage' => 'integer|min:3',
        ]);

        /* save data */
        $app = Application::find($id);
        $app->name = $r->input('name');
        $app->description = $r->input('description');
        $app->keyword = $r->input('keyword');
        $app->tagline = $r->input('tagline');
        $app->status = bool($r->input('status')) ? 1 : 0;
        $app->active_at = $r->input('active_at');
        $app->email = $r->input('email');
        $app->address = $r->input('address');
        $app->phone = $r->input('phone');
        $app->coordinate = str_replace(" ", "", $r->input('coordinate'));
        $app->perpage = $r->input('perpage');
        $app->enable_subscribe = bool($r->enable_subscribe) ? 1 : 0;
        $app->enable_like = bool($r->enable_like) ? 1 : 0;
        $app->enable_share = bool($r->enable_share) ? 1 : 0;
        $app->enable_comment = bool($r->enable_comment) ? 1 : 0;
        $app->google_analytics = $r->input('google_analytics');

        /* upload logo */
        if ($r->hasFile('logo')) {
            $file = $r->file('logo');
            $par = [
                'file' => $file,
                'folder' => '/assets/images/',
                'name' => 'logo',
                'type' => $file->getMimeType(),
                'ext' => $file->getClientOriginalExtension(),
            ];

            if ($this->uploadImage($par, true)) {
                $app->logo = $par['name'] . '.' . $par['ext'];
                // $app->save();
            }
        }

        /* upload icon */
        if ($r->input('use_logo')) {
            if ($app->logo) {
                $app->icon = $app->logo;
            }
        } else if ($r->hasFile('icon')) {
            $file = $r->file('icon');
            $par = [
                'file' => $file,
                'folder' => '/assets/images/',
                'name' => 'icon',
                'type' => $file->getMimeType(),
                'ext' => $file->getClientOriginalExtension(),
            ];

            if ($this->uploadImage($par)) {
                $app->icon = $par['name'] . '.' . $par['ext'];
                // $app->save();
            }
        }

        /* save config app */
        $app->save();

        /* processing socmed */
        $del = SocmedData::where([
            'type' => 'config',
        ])->forceDelete();
        foreach ($r->input('socmed_id') as $key => $val) {
            if ($r->input('socmed_id')[$key] != "" && $r->input('socmed_uname')[$key] != "") {
                $socmed = new SocmedData;
                $socmed->username = $r->input('socmed_uname')[$key];
                $socmed->type = 'config';
                $socmed->socmed_id = $r->input('socmed_id')[$key];
                $socmed->save();
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
