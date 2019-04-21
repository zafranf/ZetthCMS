<?php

namespace App\Http\Controllers;

class SiteController extends Controller
{
    public function index()
    {
        $this->visitorLog();
        return view('welcome');
    }
}
