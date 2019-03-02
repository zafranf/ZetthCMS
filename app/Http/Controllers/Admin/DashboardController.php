<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;

class DashboardController extends AdminController
{
    private $current_url;
    private $page_title;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->current_url = url('/setting/roles');
        $this->page_title = 'Dashboard Admin';
        /* $this->breadcrumbs[] = [
    'page' => 'Dashboard',
    'url' => '',
    'icon' => '',
    ]; */
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'current_url' => $this->current_url,
            'page_title' => $this->page_title,
            'page_subtitle' => 'Dashboard',
            'breadcrumbs' => $this->breadcrumbs,
        ];

        return view('admin.layouts.main', $data);
    }
}
