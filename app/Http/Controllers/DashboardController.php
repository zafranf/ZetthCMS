<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private $current_url;
    private $page_title;

    public function __construct()
    {
        $this->current_url = url('/setting/roles');
        $this->page_title = 'Pengaturan Peran dan Akses';
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
        ];

        return view('layouts.main', $data);
    }
}
