<?php

namespace App\Http\Controllers\Admin\Content\Article;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Term;
use Illuminate\Http\Request;

class TagController extends AdminController
{
    private $current_url;
    private $page_title;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->current_url = url('/content/tags');
        $this->page_title = 'Pengaturan Label';
        $this->breadcrumbs[] = [
            'page' => 'Label',
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
        /* set variable for view */
        $data = [
            'current_url' => $this->current_url,
            'page_title' => $this->page_title,
            'page_subtitle' => 'Daftar Label',
        ];

        return view('admin.content.tag', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /* set variable for view */
        $data = [
            'current_url' => $this->current_url,
            'page_title' => $this->page_title,
            'page_subtitle' => 'Tambah Label',
        ];

        return view('admin.content.tag_form', $data);
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
            'name' => 'required|unique:terms,name,NULL,created_at,type,tag',
        ]);

        /* save data */
        $name = str_sanitize($r->input('name'));
        $tag = new Term;
        $tag->name = $name;
        $tag->slug = str_slug($name);
        $tag->description = str_sanitize($r->input('description'));
        $tag->type = 'tag';
        $tag->parent_id = (int) $r->input('parent');
        $tag->status = bool($r->input('status')) ? 1 : 0;
        $tag->save();

        /* log aktifitas */
        $this->activityLog('<b>' . \Auth::user()->fullname . '</b> menambahkan Label "' . $tag->name . '"');

        return redirect($this->current_url)->with('success', 'Label berhasil ditambah!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Term  $tag
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort(403);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Term  $tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Term $tag)
    {
        /* set variable for view */
        $data = [
            'current_url' => $this->current_url,
            'page_title' => $this->page_title,
            'page_subtitle' => 'Sunting Label',
            'data' => $tag,
        ];

        return view('admin.content.tag_form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $r
     * @param  \App\Models\Term  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $r, Term $tag)
    {
        /* validation */
        $this->validate($r, [
            'name' => 'required|unique:terms,name,' . $tag->id . ',id,type,tag',
        ]);

        /* save data */
        $name = str_sanitize($r->input('name'));
        $tag->name = $name;
        $tag->slug = str_slug($name);
        $tag->description = str_sanitize($r->input('description'));
        $tag->type = 'tag';
        $tag->parent_id = (int) $r->input('parent');
        $tag->status = bool($r->input('status')) ? 1 : 0;
        $tag->save();

        /* log aktifitas */
        $this->activityLog('<b>' . \Auth::user()->fullname . '</b> memperbarui Label "' . $tag->name . '"');

        return redirect($this->current_url)->with('success', 'Label berhasil disimpan!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Term  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Term $tag)
    {
        /* log aktifitas */
        $this->activityLog('<b>' . \Auth::user()->fullname . '</b> menghapus Label "' . $tag->name . '"');

        /* soft delete */
        $tag->delete();

        return redirect($this->current_url)->with('success', 'Label berhasil dihapus!');
    }

    /**
     * Generate DataTables
     */
    public function datatable(Request $r)
    {
        /* get data */
        $data = Term::select(sequence(), 'id', 'name', 'description', 'status')->where('type', 'tag')->get();

        /* generate datatable */
        if ($r->ajax()) {
            return $this->generateDataTable($r, $data);
        }

        abort(403);
    }
}
