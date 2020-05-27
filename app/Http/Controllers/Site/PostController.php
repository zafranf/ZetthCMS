<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $r)
    {
        /* set breadcrumbs */
        $this->breadcrumbs[] = [
            'page' => 'Artikel',
            'icon' => '',
            'url' => '',
        ];

        /* set data */
        $data = [
            'page_title' => 'Artikel Terbaru',
            'breadcrumbs' => $this->breadcrumbs,
            'posts' => _getPostsComplete(),
        ];

        /* Set SEO */
        $this->setSEO($data['page_title']);

        return view($this->getTemplate() . '.posts', $data);
    }

    public function detail(Request $r, $slug)
    {
        /* get post */
        $post = _getPost($slug);
        if (!$post) {
            abort(404);
        }

        /* +1 visited */
        $post->increment('visited');

        /* set breadcrumbs */
        $this->breadcrumbs[] = [
            'page' => 'Artikel',
            'icon' => '',
            'url' => _url(config('path.posts')),
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

    public function by(Request $r, $type, $slug)
    {
        /* set title */
        $title = $slug;
        if ($type == config('path.tag') || $type == config('path.category')) {
            $type_q = $type == config('path.tag') ? 'tag' : 'category';
            $term = \App\Models\Term::where('slug', $slug)->where('type', $type_q)->active()->first();
            if ($term) {
                $title = $term->name;
            } else {
                abort(404);
            }

            /* get posts */
            if ($type == config('path.category')) {
                $posts = _getCategoryPosts($slug);
            } else if ($type == config('path.tag')) {
                $posts = _getTagPosts($slug);
            }
        } else if ($type == config('path.author')) {
            $slug = _encrypt($slug);
            $user = \App\Models\User::where('name', $slug)->active()->first();
            if ($user) {
                $title = $user->fullname;
            } else {
                abort(404);
            }

            /* get posts */
            $posts = _getAuthorPosts($slug);
        }

        /* set breadcrumbs */
        $this->breadcrumbs[] = [
            'page' => $title,
            'icon' => '',
            'url' => '',
        ];

        /* set data */
        $data = [
            'page_title' => 'Artikel terbaru dari ' . $type . ': ' . $title,
            'breadcrumbs' => $this->breadcrumbs,
            'posts' => $posts,
        ];

        /* Set SEO */
        $this->setSEO($data['page_title']);

        return view($this->getTemplate() . '.posts', $data);
    }
}
