<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Term;

class AjaxController extends Controller
{
    public function term($term)
    {
        $arr = [];
        if ($term == "tags") {
            $t = "tag";
        } else if ($term == "categories") {
            $t = "category";
        } else {
            abort(404);
        }

        $data = Term::select('display_name')->
            where('type', $t)->
            where('status', 1)->
            get();

        foreach ($data as $value) {
            $arr[] = $value->display_name;
        }

        return response()->json($arr);
    }
}
