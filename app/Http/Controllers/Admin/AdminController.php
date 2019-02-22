<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public $breadcrumbs = [
        [
            'icon' => 'fa fa-home',
            'page' => 'Beranda',
            'url' => '/',
        ],
    ];

    public function __construct()
    {
    }
}
