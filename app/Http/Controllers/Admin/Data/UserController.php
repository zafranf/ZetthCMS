<?php

namespace App\Http\Controllers\Admin\Data;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends AdminController
{
    private $current_url;
    private $page_title;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->current_url = url('/data/users');
        $this->page_title = 'Pengaturan Pengguna';
        $this->breadcrumbs[] = [
            'page' => 'Pengguna',
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
        /* set variable for view */
        $data = [
            'current_url' => $this->current_url,
            'page_title' => $this->page_title,
            'page_subtitle' => 'Daftar Pengguna',
        ];

        return view('admin.data.user', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /* where roles */
        if (\Auth::user()->hasRole('super')) {
            $whrRole = [
                ['status', 1],
            ];
        } else if (\Auth::user()->hasRole('admin')) {
            $whrRole = [
                ['status', 1],
                ['id', '!=', 1]
            ];
        } else {
            $whrRole = [
                ['status', 1],
                ['id', '!=', 1],
                ['id', '!=', 2],
            ];
        }

        /* set variable for view */
        $data = [
            'current_url' => $this->current_url,
            'page_title' => $this->page_title,
            'page_subtitle' => 'Tambah Pengguna',
            'roles' => Role::where($whrRole)->get(),
        ];

        return view('admin.data.user_form', $data);
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
            'name' => 'required|alpha_num|min:3|max:30|unique:users',
            'fullname' => 'required|min:1|max:100',
            'email' => 'required|email',
            'image' => 'mimes:jpg,jpeg,png,svg|max:200|dimensions:max_width=500,max_height=500',
            'password' => 'required',
            'password_confirmation' => 'same:password',
        ]);

        /* save data */
        $user = new User;
        $user->name = str_sanitize($r->input('name'));
        $user->fullname = str_sanitize($r->input('fullname'));
        $user->email = str_sanitize($r->input('email'));
        $user->password = bcrypt($r->input('password'));
        $user->language = str_sanitize($r->input('language'));
        $user->status = bool($r->input('status')) ? 1 : 0;
        $user->save();

        /* upload image */
        if ($r->hasFile('image')) {
            $file = $r->file('image');
            $par = [
                'file' => $file,
                'folder' => '/images/user/',
                'name' => str_slug($user->name),
                'type' => $file->getMimeType(),
                'ext' => $file->getClientOriginalExtension(),
            ];

            if ($this->uploadImage($par)) {
                $user->image = $par['name'] . '.' . $par['ext'];
                $user->save();
            }
        }

        /* attach role */
        $this->assignRole($user, $r->input('role'));

        /* log aktifitas */
        $this->activityLog('<b>' . \Auth::user()->fullname . '</b> menambahkan Pengguna "' . $user->name . '"');

        return redirect($this->current_url)->with('success', 'Pengguna berhasil ditambah!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        abort(403);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        /* where roles */
        if (\Auth::user()->hasRole('super')) {
            $whrRole = [
                ['status', 1],
            ];
        } else if (\Auth::user()->hasRole('admin')) {
            $whrRole = [
                ['status', 1],
                ['id', '!=', 1]
            ];
        } else {
            $whrRole = [
                ['status', 1],
                ['id', '!=', 1],
                ['id', '!=', 2],
            ];
        }

        /* set variable for view */
        $data = [
            'current_url' => $this->current_url,
            'page_title' => $this->page_title,
            'page_subtitle' => 'Sunting Pengguna',
            'roles' => Role::where($whrRole)->get(),
            'data' => $user,
        ];

        return view('admin.data.user_form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $r
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $r, User $user)
    {
        /* validation */
        $this->validate($r, [
            'name' => 'required|alpha_num|min:3|max:30|unique:users,name,' . $user->id . ',id',
            'fullname' => 'required|min:1|max:100',
            'email' => 'required|email',
            'image' => 'mimes:jpg,jpeg,png,svg|max:200|dimensions:max_width=500,max_height=500',
        ]);

        /* validasi password jika ada */
        if ($r->input('password') !== null || $r->input('password_confirmation') !== null) {
            $this->validate($r, [
                'password' => 'required',
                'password_confirmation' => 'same:password',
            ]);
        }

        /* save data */
        $user->name = str_sanitize($r->input('name'));
        $user->fullname = str_sanitize($r->input('fullname'));
        $user->email = str_sanitize($r->input('email'));
        $user->password = bcrypt($r->input('password'));
        $user->language = str_sanitize($r->input('language'));
        $user->status = bool($r->input('status')) ? 1 : 0;
        $user->save();

        /* upload image */
        if ($r->hasFile('image')) {
            $file = $r->file('image');
            $par = [
                'file' => $file,
                'folder' => '/images/user/',
                'name' => str_slug($r->input('name')),
                'type' => $file->getMimeType(),
                'ext' => $file->getClientOriginalExtension(),
            ];

            if ($this->uploadImage($par)) {
                $user->image = $par['name'] . '.' . $par['ext'];
                $user->save();
            }
        }

        /* attach role */
        $this->assignRole($user, $r->input('role'));

        /* log aktifitas */
        $this->activityLog('<b>' . \Auth::user()->fullname . '</b> memperbarui Pengguna "' . $user->name . '"');

        return redirect($this->current_url)->with('success', 'Pengguna berhasil disimpan!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $r, User $user)
    {
        /* log aktifitas */
        $this->activityLog('<b>' . \Auth::user()->fullname . '</b> menghapus Pengguna "' . $user->name . '"');

        /* soft delete */
        $user->delete();

        return redirect($this->current_url)->with('success', 'Pengguna berhasil dihapus!');
    }

    /**
     * Generate DataTables
     */
    public function datatable(Request $r)
    {
        /* get data */
        $data = User::select(sequence(), 'id', 'name', 'fullname', 'status')->get();
        
        /* generate datatable */
        if ($r->ajax()) {
            return $this->generateDataTable($r, $data);
        }

        abort(403);
    }

    /**
     * Assign user to a role 
     */
    public function assignRole($user, $newRole)
    {
        /* hapus role sebelumnya */
        foreach ($user->roles as $role) {
            $user->detachRole($role->id);
        }

        /* tambah role baru */
        $user->attachRole($newRole);
    }
}
