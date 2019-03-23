<?php

namespace App\Http\Controllers;

class TestController extends Controller
{
    public function index()
    {
        dd(urls('asdasda', true, ['test']));
    }
}
