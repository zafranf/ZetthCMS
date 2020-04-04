<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;

class MiscController extends Controller
{
    public function index(Request $r, $type, $slug)
    {

    }

    public function comingsoon(Request $r)
    {
        $data = [
            'page_title' => 'Segera hadir!',
        ];

        /* Set SEO */
        $this->setSEO($data['page_title']);

        return view($this->getTemplate() . '.misc.comingsoon', $data);
    }

    public function maintenance(Request $r)
    {
        $data = [
            'page_title' => 'Situs sedang dalam perbaikan!',
        ];

        /* Set SEO */
        $this->setSEO($data['page_title']);

        return view($this->getTemplate() . '.misc.maintenance', $data);
    }
}
