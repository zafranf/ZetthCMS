<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public $breadcrumbs;

    public function __construct()
    {
        $this->breadcrumbs[] = [
            'page' => 'Beranda',
            'icon' => '',
            'url' => url('/dashboard'),
        ];
    }
}
