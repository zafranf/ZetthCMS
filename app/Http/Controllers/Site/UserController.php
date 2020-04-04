<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $r)
    {
        /* check segment */
        if ($r->segment(1) == 'profil') {
            return redirect(url(\Auth::user()->name));
        }

        /* set breadcrumbs */
        $this->breadcrumbs[] = [
            'page' => 'Profil',
            'icon' => '',
            'url' => '',
        ];

        /* set data */
        $data = [
            'page_title' => 'Profil',
            'breadcrumbs' => $this->breadcrumbs,
        ];

        /* Set SEO */
        $this->setSEO($data['page_title']);

        return view($this->getTemplate() . '.user.profile', $data);
    }

    public function edit(Request $r)
    {
        /* set breadcrumbs */
        $this->breadcrumbs[] = [
            'page' => 'Edit Profil',
            'icon' => '',
            'url' => '',
        ];

        /* set data */
        $data = [
            'page_title' => 'Edit Profil',
            'breadcrumbs' => $this->breadcrumbs,
        ];

        /* Set SEO */
        $this->setSEO($data['page_title']);

        return view($this->getTemplate() . '.user.profile_edit', $data);
    }

    public function update(Request $r)
    {
        /* check validation */
        $this->validate($r, [
            'name' => ['required', 'alpha_dash', 'min:3', 'max:30', 'unique:users,name,' . app('user')->id . ',id'],
            'fullname' => ['required', 'max:100'],
            'image' => 'mimes:jpg,jpeg,png,svg|max:384|dimensions:min_width=128,min_height=128,max_width=512,max_height=512,ratio=1/1',
        ]);

        /* save user */
        $user = app('user');
        $user->name = $r->input('name');
        $user->fullname = $r->input('fullname');
        $user->gender = $r->input('gender');
        $user->birthdate = $r->input('birthdate');
        $user->address = $r->input('address');
        $user->about = $r->input('about');

        /* set password */
        if ($r->input('use_password') && !is_null($r->input('password'))) {
            $user->password = Hash::make($r->input('password'));
        }

        /* upload image */
        if ($r->hasFile('image')) {
            $file = $r->file('image');
            $par = [
                'file' => $file,
                'folder' => '/assets/images/users/',
                'name' => md5($user->id * env('DB_PORT', 3306)),
                'type' => $file->getClientMimeType(),
                'ext' => $file->getClientOriginalExtension(),
            ];

            /* upload image */
            if ($this->uploadImage($par)) {
                $user->image = $par['name'] . '.' . $par['ext'];
            }
        }

        /* save user */
        $user->save();

        return redirect(route('web.profile.edit'))->with('success', true);
    }
}
