<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Site\Controller;
use Illuminate\Http\Request;

class TestController extends Controller
{
    use \ZetthCore\Traits\MainTrait;

    public function index(Request $r)
    {
        return view('WebSC.emails.verify', [
            'name' => 'Zafran Fadilah',
            'email' => 'zafran@fadilah.id',
            'verify_code' => 'asdqwdjaduiqwh1209ejdjkasd21jij',
        ]);
    }
}
