<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Term;
use App\Models\VisitorLog;
use DB;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function term($term)
    {
        $arr = [];
        if ($term == "tags") {
            $type = "tag";
        } else if ($term == "categories") {
            $type = "category";
        } else {
            abort(404);
        }

        $data = Term::select('display_name')->
            where('type', $type)->
            where('status', 1)->
            get();

        foreach ($data as $value) {
            $arr[] = $value->display_name;
        }

        return response()->json($arr);
    }

    public function pageview(Request $r)
    {
        $data_visit = [];
        $res = [
            'rows' => [
                [
                    'name' => 'Visits',
                    'data' => [],
                    'color' => 'coral',
                ],
                [
                    'name' => 'Unique Visitors',
                    'data' => [],
                    'color' => 'grey',
                ],
            ],
            'status' => false,
        ];

        $start = $r->input('start');
        $end = $r->input('end');
        $range = $r->input('range');

        switch ($range) {
            case 'hourly':
                $df = '%Y-%m-%d %H';
                break;
            case 'monthly':
                $df = '%Y-%m';
                break;
            case 'yearly':
                $df = '%Y';
                break;
            case 'daily':
                $df = '%Y-%m-%d';
                break;
            default:
                return response()->json($res);
                break;
        }

        $visits = VisitorLog::select('ip', DB::raw('date_format(created_at, \'' . $df . '\') as created'), DB::raw('sum(count) as count'))->
            whereBetween('created_at', [$start . ' 00:00:00', $end . ' 23:59:59'])->
            orderBy('created_at', 'ASC')->
            groupBy(DB::raw('date_format(created_at, \'' . $df . '\')'), 'ip')->
            get();

        if ($visits) {
            switch ($range) {
                case 'hourly':
                    $arr_diff = $this->pageview_hourly($visits);
                    break;
                case 'monthly':
                    $arr_diff = $this->pageview_monthly($visits, $start);
                    break;
                case 'yearly':
                    $arr_diff = $this->pageview_yearly($visits, $start);
                    break;
                case 'daily':
                    $arr_diff = $this->pageview_daily($visits, $start);
                    break;
                default:
                    return response()->json($res);
                    break;
            }

            if (!empty($arr_diff)) {
                foreach ($arr_diff as $k => $v) {
                    $data_visit[$v]['visit'] = 0;
                    $data_visit[$v]['ip'] = 0;
                }
            }

            $time2 = '';
            foreach ($visits as $k => $v) {
                if ($time2 != $v->created) {
                    $data_visit[$v->created]['visit'] = $v->count;
                    $data_visit[$v->created]['ip'] = 1;
                } else {
                    $data_visit[$v->created]['visit'] = $v->count + $data_visit[$v->created]['visit'];
                    $data_visit[$v->created]['ip'] = $data_visit[$v->created]['ip'] + 1;
                }

                $time2 = $v->created;
                $ip = $v->ip;
            }

            $res['status'] = true;

            foreach (array_sort_recursive($data_visit) as $k => $v) {
                $res['rows'][0]['data'][] = (int) $v['visit'];
                $res['rows'][1]['data'][] = (int) $v['ip'];
            }
        }

        return response()->json($res);
    }

    public function pageview_hourly($visits = [])
    {
        $time = '';
        $timee = '';
        $time_exist = [];
        $time_from_max = [];
        $arr_diff = [];

        if (empty($visits)) {
            return false;
        }

        foreach ($visits as $k => $v) {
            if ($time != $v->created) {
                $time_exist[] = $v->created;
            }

            $time = $v->created;
            $timee = $v->created_at;
        }

        $max = substr($timee, -8, 2);
        for ($i = 0; $i <= $max; $i++) {
            $h = str_pad($i, 2, "0", STR_PAD_LEFT);
            $time_from_max[] = date("Y-m-d", strtotime($timee)) . " " . $h;
        }

        $arr_diff = array_diff($time_from_max, $time_exist);

        return $arr_diff;
    }

    public function pageview_daily($visits = [], $start)
    {
        $time = '';
        $timee = '';
        $time_exist = [];
        $time_from_max = [];
        $arr_diff = [];

        if (empty($visits)) {
            return false;
        }

        foreach ($visits as $k => $v) {
            if ($time != $v->created) {
                $time_exist[] = $v->created;
            }

            $time = $v->created;
            $timee = $v->created_at;
        }

        $st = date("d", strtotime($start));
        $max = date("d", strtotime($timee));
        for ($i = $st; $i <= $max; $i++) {
            $h = str_pad($i, 2, "0", STR_PAD_LEFT);
            $time_from_max[] = date("Y-m-", strtotime($timee)) . $h;
        }

        $arr_diff = array_diff($time_from_max, $time_exist);

        return $arr_diff;
    }

    public function pageview_monthly($visits = [], $start)
    {
        $time = '';
        $timee = '';
        $time_exist = [];
        $time_from_max = [];
        $arr_diff = [];

        if (empty($visits)) {
            return false;
        }

        foreach ($visits as $k => $v) {
            if ($time != $v->created) {
                $time_exist[] = $v->created;
            }

            $time = $v->created;
            $timee = $v->created_at;
        }

        $st = date("m", strtotime($start));
        $max = date("m", strtotime($timee));
        for ($i = $st; $i <= $max; $i++) {
            $h = str_pad($i, 2, "0", STR_PAD_LEFT);
            $time_from_max[] = date("Y-", strtotime($timee)) . $h;
        }

        $arr_diff = array_diff($time_from_max, $time_exist);

        return $arr_diff;
    }

    public function pageview_yearly($visits = [], $start)
    {
        $time = '';
        $timee = '';
        $time_exist = [];
        $time_from_max = [];
        $arr_diff = [];

        if (empty($visits)) {
            return false;
        }

        foreach ($visits as $k => $v) {
            if ($time != $v->created) {
                $time_exist[] = $v->created;
            }

            $time = $v->created;
            $timee = $v->created_at;
        }

        $st = date("Y", strtotime($start));
        $max = date("Y", strtotime($timee));
        for ($i = $st; $i <= $max; $i++) {
            $time_from_max[] = date("Y", strtotime($timee));
        }

        $arr_diff = array_diff($time_from_max, $time_exist);

        return $arr_diff;
    }
}
