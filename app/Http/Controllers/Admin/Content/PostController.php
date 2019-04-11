<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Post;
use App\Models\PostTerm;
use App\Models\Term;
use Illuminate\Http\Request;

class PostController extends AdminController
{
    private $current_url;
    private $page_title;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->current_url = url($this->adminPath . '/content/posts');
        $this->page_title = 'Pengaturan Artikel';
        $this->breadcrumbs[] = [
            'page' => 'Konten',
            'icon' => '',
            'url' => url($this->adminPath . '/content/banners'),
        ];
        $this->breadcrumbs[] = [
            'page' => 'Halaman',
            'icon' => '',
            'url' => $this->current_url,
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->breadcrumbs[] = [
            'page' => 'Tabel',
            'icon' => '',
            'url' => '',
        ];

        /* set variable for view */
        $data = [
            'current_url' => $this->current_url,
            'breadcrumbs' => $this->breadcrumbs,
            'page_title' => $this->page_title,
            'page_subtitle' => 'Tabel Artikel',
        ];

        return view('admin.AdminSC.content.posts', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->breadcrumbs[] = [
            'page' => 'Tambah',
            'icon' => '',
            'url' => '',
        ];

        $categories = Term::where('type', 'category')
            ->where('status', 1)
            ->orderBy('name', 'asc')
            ->get();

        /* set variable for view */
        $data = [
            'current_url' => $this->current_url,
            'page_title' => $this->page_title,
            'breadcrumbs' => $this->breadcrumbs,
            'page_subtitle' => 'Tambah Artikel',
            'categories' => $categories,
        ];

        return view('admin.AdminSC.content.posts_form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $r
     * @return \Illuminate\Http\Response
     */
    public function store(Request $r)
    {
        /* validation */
        $this->validate($r, [
            'title' => 'required|max:100|unique:posts,title,NULL,created_at,type,article',
            'slug' => 'unique:posts,slug,NULL,created_at,type,article',
            'content' => 'required',
            'categories' => 'required',
            'tags' => 'required',
        ]);

        /* set variables */
        $title = $r->input('title');
        $slug = str_slug($r->input('slug'));
        $categories = $r->input('categories');
        $descriptions = $r->input('descriptions');
        $parents = $r->input('parents');
        $tags = explode(",", $r->input('tags'));
        $url = url('/');
        $digit = 3;
        $uniq = str_random($digit);
        $cover = str_replace($url, "", $r->input('cover'));
        $date = ($r->input('date') == '') ? date("Y-m-d") : $r->input('date');
        $time = ($r->input('time') == '') ? date("H:i") : $r->input('time');

        /* save data */
        $post = new Post;
        $post->title = $title;
        $post->slug = $slug;
        $post->content = $r->input('content');
        $post->excerpt = $r->input('excerpt');
        $post->type = 'article';
        $post->cover = $cover;
        $post->status = $r->input('status');
        $post->share = ($r->input('share')) ? 1 : 0;
        $post->like = ($r->input('like')) ? 1 : 0;
        $post->comment = ($r->input('comment')) ? 1 : 0;
        $post->published_at = $date . ' ' . $time;
        // $post->short_url = $uniq;
        $post->created_by = \Auth::user()->id;
        $post->save();

        /* delete post relation */
        PostTerm::where('post_id', $post->id)->delete();

        /* processing categories */
        $this->process_categories($categories, $descriptions, $parents, $post->id);

        /* processing tags */
        $this->process_tags($tags, $post->id);

        /* log aktifitas */
        $this->activityLog('<b>' . \Auth::user()->fullname . '</b> menambahkan Artikel "' . $post->title . '"');

        return redirect($this->current_url)->with('success', 'Artikel "' . $post->title . '" berhasil ditambah!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        /* initial config */
        $this->_init_config();

        $this->init['title_box'] = 'Show post';
        $this->init['breadcrumb'][] = [
            'page' => 'Show',
            'url' => '',
        ];
        $this->_init_session($this->init);

        $post = Post::where('post_id', $id)->with('terms')->first();
        if (!$post) {
            abort(404);
        }

        $data = [];
        $data['post'] = $post;

        return view('admin.web.posts_detail', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $this->breadcrumbs[] = [
            'page' => 'Edit',
            'icon' => '',
            'url' => '',
        ];

        $categories = Term::where('type', 'category')
            ->where('status', 1)
            ->orderBy('name', 'asc')
            ->get();

        /* set variable for view */
        $data = [
            'current_url' => $this->current_url,
            'page_title' => $this->page_title,
            'breadcrumbs' => $this->breadcrumbs,
            'page_subtitle' => 'Edit Artikel',
            'categories' => $categories,
            'data' => $post->load('terms'),
        ];

        return view('admin.AdminSC.content.posts_form', $data);
    }

    public function update(Request $r, $id)
    {
        /* initial config */
        $this->_init_config();

        //validation
        $this->validate($r, [
            'post_title' => 'required|max:100|unique:posts,post_title,' . $id . ',post_id,post_type,article,app_id,' . $this->app_id,
            'post_slug' => 'required|max:100|unique:posts,post_slug,' . $id . ',post_id,post_type,article,app_id,' . $this->app_id,
            'post_content' => 'required',
            'post_categories' => 'required',
            'post_tags' => 'required',
        ]);

        //defining variables
        $cover = '';
        $title = $r->post_title;
        $slug = str_slug($r->post_slug);
        $categories = $r->post_categories;
        $descriptions = $r->post_descriptions;
        $parents = $r->post_parents;
        $tags = explode(",", $r->post_tags);
        $url = Session::get('app')->app_domain;
        $cover = str_replace(url('/'), "", $r->post_cover);
        $date = ("" == $r->post_date) ? date("Y-m-d") : $r->post_date;
        $time = ("" == $r->post_time) ? date("H:i") : $r->post_time;

        //processing post
        $post = Post::find($id);
        $post->post_title = $title;
        // $post->post_slug    = $slug;
        $post->post_content = $r->post_content;
        $post->post_excerpt = $r->post_excerpt;
        if ($cover != '') {
            $post->post_cover = $cover;
        }
        if (isset($r->post_cover_remove)) {
            $post->post_cover = '';
        }
        $post->post_status = $r->post_status;
        $post->post_share = ($r->post_share) ? 1 : 0;
        $post->post_like = ($r->post_like) ? 1 : 0;
        $post->post_comment = ($r->post_comment) ? 1 : 0;
        $post->published_at = $date . ' ' . $time;
        $post->updated_by = \Auth::user()->id;
        $post->save();

        //delete post relation
        PostTerm::where('post_id', $id)->delete();

        //processing categories
        $this->process_categories($categories, $descriptions, $parents, $id);

        //processing tags
        $this->process_tags($tags, $id);

        /* clear cache */
        // Cache::flush();

        return redirect($this->current_url)->with('success', 'Post has been updated!');
    }

    public function destroy($id, Request $r)
    {
        /* initial config */
        $this->_init_config();

        if ($r->hard_delete) {
            Post::find($id)->forceDelete();
            PostTerm::where('post_id', $id)->delete();
        } else {
            Post::find($id)->delete();
        }

        /* clear cache */
        Cache::flush();

        return redirect(Session::get('current_url'))->with('success', 'Post has been deleted!');
    }

    /**
     * Generate DataTables
     */
    public function datatable(Request $r)
    {
        /* get data */
        $data = Post::select('id', 'title', 'slug', 'status')->where('type', 'article')->orderBy('id', 'desc')->get();

        /* generate datatable */
        if ($r->ajax()) {
            return $this->generateDataTable($r, $data);
        }

        abort(403);
    }

    public function process_categories($categories, $descriptions, $parents, $pid)
    {
        foreach ($categories as $k => $category) {
            $chkCategory = Term::where('name', str_slug($category))
                ->where('type', 'category')
                ->first();

            if (!$chkCategory) {
                $term = new Term;
                $term->name = str_slug($category);
                $term->display_name = $category;
                $term->description = $descriptions[$k];
                $term->parent = $parents[$k];
                $term->type = 'category';
                $term->status = 1;
                $term->save();

                $cid = $term->id;
            } else {
                $cid = $chkCategory->id;
            }

            /* process relations */
            $this->process_postrels($pid, $cid);
        }
    }

    public function process_tags($tags, $pid)
    {
        foreach ($tags as $tag) {
            $chkTag = Term::where('name', str_slug($tag))->
                where('type', 'tag')->
                first();

            if (!$chkTag) {
                $term = new Term;
                $term->name = str_slug($tag);
                $term->display_name = strtolower($tag);
                $term->type = 'tag';
                $term->status = 1;
                $term->save();

                $tid = $term->id;
            } else {
                $tid = $chkTag->id;
            }

            /* process relations */
            $this->process_postrels($pid, $tid);
        }
    }

    public function process_postrels($pid, $tid)
    {
        $postrel = new PostTerm;
        $postrel->post_id = $pid;
        $postrel->term_id = $tid;
        $postrel->save();
    }

}
