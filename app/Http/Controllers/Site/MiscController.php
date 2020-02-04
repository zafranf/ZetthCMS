<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Site\Controller;
use Illuminate\Http\Request;

class MiscController extends Controller
{
    public function index(Request $r, $type, $slug)
    {

    }

    public function comingsoon(Request $r)
    {
        $data = [
            'page_title' => 'Segera hadir..',
        ];

        /* Set SEO */
        $this->setSEO($data['page_title']);

        return view($this->getTemplate() . '.comingsoon', $data);
    }

    public function maintenance(Request $r)
    {
        $data = [
            'page_title' => 'Sedang dalam perbaikan..',
        ];

        /* Set SEO */
        $this->setSEO($data['page_title']);

        return view($this->getTemplate() . '.comingsoon', $data);
    }
}
