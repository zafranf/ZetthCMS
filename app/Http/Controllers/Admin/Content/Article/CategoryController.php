<?php

namespace App\Http\Controllers\Admin\Content\Article;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Term;
use Illuminate\Http\Request;

class CategoryController extends AdminController
{
    private $current_url;
    private $page_title;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->current_url = url('/content/categories');
        $this->page_title = 'Pengaturan Kategori';
        $this->breadcrumbs[] = [
            'page' => 'Kategori',
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
            'page_subtitle' => 'Daftar Kategori',
        ];

        return view('admin.content.category', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /* get data */
        $categories = Term::where('type', 'category')->orderBy('name')->get();

        /* set variable for view */
        $data = [
            'current_url' => $this->current_url,
            'page_title' => $this->page_title,
            'page_subtitle' => 'Tambah Kategori',
            'categories' => $categories,
        ];

        return view('admin.content.category_form', $data);
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
            'name' => 'required|unique:terms,name,NULL,created_at,type,category',
        ]);

        /* save data */
        $name = str_sanitize($r->input('name'));
        $category = new Term;
        $category->name = $name;
        $category->slug = str_slug($name);
        $category->description = str_sanitize($r->input('description'));
        $category->type = 'category';
        $category->parent_id = (int) $r->input('parent');
        $category->status = bool($r->input('status')) ? 1 : 0;
        $category->save();

        /* log aktifitas */
        $this->activityLog('<b>' . \Auth::user()->fullname . '</b> menambahkan Kategori "' . $category->name . '"');

        return redirect($this->current_url)->with('success', 'Kategori berhasil ditambah!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Term  $category
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort(403);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Term  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Term $category)
    {
        /* get data */
        $categories = Term::where('type', 'category')->orderBy('name')->get();

        /* set variable for view */
        $data = [
            'current_url' => $this->current_url,
            'page_title' => $this->page_title,
            'page_subtitle' => 'Sunting Kategori',
            'categories' => $categories,
            'data' => $category,
        ];

        return view('admin.content.category_form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $r
     * @param  \App\Models\Term  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $r, Term $category)
    {
        /* validation */
        $this->validate($r, [
            'name' => 'required|unique:terms,name,' . $category->id . ',id,type,category',
        ]);

        /* save data */
        $name = str_sanitize($r->input('name'));
        $category->name = $name;
        $category->slug = str_slug($name);
        $category->description = str_sanitize($r->input('description'));
        $category->type = 'category';
        $category->parent_id = (int) $r->input('parent');
        $category->status = bool($r->input('status')) ? 1 : 0;
        $category->save();

        /* log aktifitas */
        $this->activityLog('<b>' . \Auth::user()->fullname . '</b> memperbarui Kategori "' . $category->name . '"');

        return redirect($this->current_url)->with('success', 'Kategori berhasil disimpan!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Term  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Term $category)
    {
        /* log aktifitas */
        $this->activityLog('<b>' . \Auth::user()->fullname . '</b> menghapus Kategori "' . $category->name . '"');

        /* soft delete */
        $category->delete();

        return redirect($this->current_url)->with('success', 'Kategori berhasil dihapus!');
    }

    /**
     * Generate DataTables
     */
    public function datatable(Request $r)
    {
        /* get data */
        $data = Term::select(sequence(), 'id', 'name', 'description', 'status')->where('type', 'category')->get();

        /* generate datatable */
        if ($r->ajax()) {
            return $this->generateDataTable($r, $data);
        }

        abort(403);
    }
}
