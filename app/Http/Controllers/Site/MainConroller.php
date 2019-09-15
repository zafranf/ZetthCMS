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
            'banners' => \ZetthCore\Models\Banner::where('status', 1)->orderBy('order')->get(),
            'posts' => \ZetthCore\Models\Post::where('status', 1)->where('type', 'article')->orderBy('published_at', 'desc')->take(5)->get(),
            'categories' => \ZetthCore\Models\Term::where('status', 1)->where('type', 'category')->get(),
            'tags' => \ZetthCore\Models\Term::where('status', 1)->where('type', 'tag')->get(),
            'albums' => \ZetthCore\Models\Album::where('status', 1)->where('type', 'photo')->get(),
            'videos' => \ZetthCore\Models\Post::where('status', 1)->where('type', 'video')->orderBy('published_at', 'desc')->take(5)->get(),
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
