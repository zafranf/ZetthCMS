<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use ZetthCore\Http\Controllers\SiteController;

class PageController extends SiteController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $r, $slug)
    {
        /* get page */
        $page = _getPage($slug); //\App\Models\Post::pages()->active()->where('slug', $slug)->first();
        if (!$page) {
            abort(404);
        }

        /* +1 visited */
        $page->increment('visited');

        /* set breadcrumbs */
        $this->breadcrumbs[] = [
            'page' => 'Berita',
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
}
