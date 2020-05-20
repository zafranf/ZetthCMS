<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $r, $slug = null)
    {
        /* check username */
        $user = \App\Models\User::active()->where('name', _encrypt($slug))->first();
        if ($user) {
            return $this->user($r, $user);
        }

        /* get page */
        $page = _getPage($slug);
        if (!$page) {
            abort(404);
        }

        /* +1 visited */
        $page->increment('visited');

        /* set breadcrumbs */
        $this->breadcrumbs[] = [
            'page' => 'Halaman',
            'icon' => '',
            'url' => '',
        ];

        $data = [
            'page_title' => $page->title,
            'breadcrumbs' => $this->breadcrumbs,
            'page' => $page,
        ];

        /* Set SEO */
        $this->setSEO($data['page_title'], $data['page']);

        return view($this->getTemplate() . '.page', $data);
    }

    public function contact(Request $r)
    {
        $this->breadcrumbs[] = [
            'page' => 'Kontak',
            'icon' => '',
            'url' => '',
        ];

        $data = [
            'page_title' => 'Hubungi Kami',
            'breadcrumbs' => $this->breadcrumbs,
        ];

        /* Set SEO */
        $this->setSEO($data['page_title']);

        return view($this->getTemplate() . '.contact', $data);
    }

    public function user(Request $r, User $user)
    {
        /* set breadcrumbs */
        $this->breadcrumbs[] = [
            'page' => $user->fullname,
            'icon' => '',
            'url' => '',
        ];

        /* set data */
        $data = [
            'page_title' => $user->fullname,
            'breadcrumbs' => $this->breadcrumbs,
            'user' => $user,
        ];

        /* Set SEO */
        $this->setSEO($data['page_title']);

        return view($this->getTemplate() . '.user.profile', $data);
    }
}
