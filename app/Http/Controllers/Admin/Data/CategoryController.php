<?php

namespace App\Http\Controllers\Admin\Data;

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
        $this->current_url = url('/admin/data/categories');
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
        /* get data */
        $categories = Term::select(sequence(), 'id', 'name', 'description', 'status')->where('type', 'category')->orderBy('name', 'asc')->get();

        /* set variable for view */
        $data = [
            'current_url' => $this->current_url,
            'page_title' => $this->page_title,
            'page_subtitle' => 'Daftar Kategori',
            'data' => $categories,
        ];

        return view('admin.data.category', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /* get data */
        $categories = Term::where('type', 'category')->
            where('status', 1)->
            orderBy('name', 'asc')->
            get();

        /* set variable for view */
        $data = [
            'current_url' => $this->current_url,
            'page_title' => $this->page_title,
            'page_subtitle' => 'Tambah Kategori',
            'categories' => $categories,
        ];

        return view('admin.data.category_form', $data);
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
        $term = new Term;
        $term->name = $name;
        $term->slug = str_slug($name);
        $term->description = str_sanitize($r->input('description'));
        $term->type = 'category';
        $term->parent_id = (int) $r->input('parent');
        $term->status = bool($r->input('status')) ? 1 : 0;
        $term->save();

        return redirect($this->current_url)->with('success', 'Kategori berhasil ditambah!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort(403);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $r
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $r, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Generate DataTables
     */
    public function datatable(Request $r)
    {
        /* get data */
        $data = Term::select(sequence(), 'id', 'name', 'description', 'status')->where('type', 'category')->orderBy('name', 'asc')->get();

        /* generate datatable */
        if ($r->ajax()) {
            return $this->generateDataTable($r, $data);
        }

        abort(403);
    }
}
