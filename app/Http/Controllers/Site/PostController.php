<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Site\Controller;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $r, $type)
    {
        /* set breadcrumbs */
        $this->breadcrumbs[] = [
            'page' => 'Berita',
            'icon' => '',
            'url' => '',
        ];

        /* set data */
        $data = [
            'page_title' => 'Berita Terbaru',
            'breadcrumbs' => $this->breadcrumbs,
            'posts' => _getPostsComplete(),
        ];

        /* Set SEO */
        $this->setSEO($data['page_title']);

        return view($this->getTemplate() . '.posts', $data);
    }

    public function detail(Request $r, $type, $slug)
    {
        /* get post */
        $post = _getPost($slug); //\App\Models\Post::articles()->active()->where('slug', $slug)->first();
        if (!$post) {
            abort(404);
        }

        /* +1 visited */
        $post->increment('visited');

        /* set breadcrumbs */
        $this->breadcrumbs[] = [
            'page' => 'Berita',
            'icon' => '',
            'url' => url('/news'),
        ];
        $this->breadcrumbs[] = [
            'page' => $post->title,
            'icon' => '',
            'url' => '',
        ];

        /* set data */
        $data = [
            'page_title' => $post->title,
            'breadcrumbs' => $this->breadcrumbs,
            'post' => $post,
        ];

        /* Set SEO */
        $this->setSEO($data['page_title'], $data['post']);

        return view($this->getTemplate() . '.post', $data);
    }

    public function term(Request $r, $term_type, $slug)
    {
        /* set title */
        $title = $term_type == 'tag' ? 'Label' : 'Kategori';

        /* set breadcrumbs */
        $this->breadcrumbs[] = [
            'page' => $title,
            'icon' => '',
            'url' => '',
        ];

        if ($term_type == 'category') {
            $posts = _getCategoryPosts($slug);
        } else if ($term_type == 'tag') {
            $posts = _getTagPosts($slug);
        }

        /* set data */
        $data = [
            'page_title' => $title . ' Berita:',
            'breadcrumbs' => $this->breadcrumbs,
            'posts' => $posts,
        ];

        return view($this->getTemplate() . '.posts', $data);
    }
}
