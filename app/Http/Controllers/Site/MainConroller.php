<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use ZetthCore\Http\Controllers\SiteController;

class MainController extends SiteController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $r)
    {
        /* get all data */
        $singleBanner = config('site.banner.single') ? 1 : 0;
        $data = [
            'page_title' => app('site')->tagline,
            'banners' => _getBanners($singleBanner),
            'posts' => _getPostsSimple(5),
            'breadcrumbs' => $this->breadcrumbs,
        ];

        /* Set SEO */
        $this->setSEO($data['page_title']);

        return view($this->getTemplate() . '.home', $data);
    }

    public function search(Request $r)
    {
        $this->breadcrumbs[] = [
            'page' => 'Pencarian',
            'icon' => '',
            'url' => '',
        ];

        $data = [
            'page_title' => 'Pencarian ' . $r->input('q'),
            'breadcrumbs' => $this->breadcrumbs,
            'posts' => \App\Models\Post::where('title', 'like', '%' . $r->input('q') . '%')
            // ->orWhere('content', 'like', '%' . $r->input('q') . '%')
                ->with('categories')
                ->withCount('comments')
                ->orderBy('published_at', 'desc')
                ->paginate(app('site')->perpage),
        ];

        /* Set SEO */
        $this->setSEO($data['page_title']);

        return view($this->getTemplate() . '.search', $data);
    }
}
