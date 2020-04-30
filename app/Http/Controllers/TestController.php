<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Site\Controller;
use Illuminate\Http\Request;

class TestController extends Controller
{
    use \ZetthCore\Traits\MainTrait;

    public function index(Request $r)
    {
        return 'hello..';
    }
}
