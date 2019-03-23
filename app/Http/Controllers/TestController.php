<?php

namespace App\Http\Controllers;

class TestController extends Controller
{
    public function index()
    {
        dd(\App\Models\Role::with('menus')->get());
    }
}
