<?php

namespace App\Http\Controllers;

class TestController extends Controller
{
    public function index()
    {
        dd(\App\Models\Menu::with('group')->orderBy('id', 'desc')->first());
    }
}
