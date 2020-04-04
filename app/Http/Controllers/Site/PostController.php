<?php

namespace App\Http\Controllers\Site;

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

    public function detail(Request $r, $type, $slug)
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
            'url' => url('/artikel'),
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
        if (in_array($type, ['tag', 'label']) || in_array($type, ['category', 'kategori'])) {
            $type_q = in_array($type, ['tag', 'label']) ? 'tag' : 'category';
            $term = \App\Models\Term::where('slug', $slug)->where('type', $type_q)->active()->first();
            if ($term) {
                $title = $term->name;
            }
        } else if (in_array($type, ['author', 'penulis'])) {
            $user = \App\Models\User::where('name', $slug)->active()->first();
            if ($user) {
                $title = $user->fullname;
            }
        }

        /* set breadcrumbs */
        $this->breadcrumbs[] = [
            'page' => $title,
            'icon' => '',
            'url' => '',
        ];

        /* get posts */
        if (in_array($type, ['category', 'kategori'])) {
            $posts = _getCategoryPosts($slug);
        } else if (in_array($type, ['tag', 'label'])) {
            $posts = _getTagPosts($slug);
        } else if (in_array($type, ['author', 'penulis'])) {
            $posts = _getAuthorPosts($slug);
        }

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
