<?php

namespace App\Http\Controllers;

class TestController extends Controller
{
    public function index()
    {
        $tes = \App\Models\VisitorLog::where('created_at', '>=', [date("Y-m-d H:00:00"), date("Y-m-d H:59:59")]);
        dd($tes);
    }
}
