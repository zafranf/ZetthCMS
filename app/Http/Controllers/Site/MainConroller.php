<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index(Request $r)
    {
        /* get all data */
        $data = [
            'banners' => _getBanners(),
            'posts' => _getPosts(),
            'categories' => _getTerms('category'),
            'tags' => _getTerms('tag'),
            'albums' => _getAlbums(),
            'videos' => _getVideos(),
        ];

        return view('site.main', $data);
    }

    public function contact(Request $r)
    {

    }

    public function search(Request $r)
    {

    }
}
