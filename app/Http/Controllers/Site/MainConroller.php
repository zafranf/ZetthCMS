<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;

class MainController extends Controller
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
            'posts' => _getPostsSimple(),
            'breadcrumbs' => $this->breadcrumbs,
        ];

        /* Set SEO */
        $this->setSEO($data['page_title']);

        return view($this->getTemplate() . '.home', $data);
    }

    public function search(Request $r)
    {
        /* set breadcrumbs */
        $this->breadcrumbs[] = [
            'page' => 'Pencarian',
            'icon' => '',
            'url' => '',
        ];

        /* set data */
        $keyword = $r->input('q');
        $data = [
            'page_title' => 'Pencarian: ' . $keyword,
            'breadcrumbs' => $this->breadcrumbs,
            'posts' => _getSearchPosts($keyword),
        ];

        /* Set SEO */
        $this->setSEO($data['page_title']);

        return view($this->getTemplate() . '.search', $data);
    }
}
