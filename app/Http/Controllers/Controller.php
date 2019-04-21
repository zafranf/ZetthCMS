<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

// use Yajra\DataTables\Facades\DataTables;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, \App\Traits\MainTrait;

    private $mail_id;
    public $isAdminSubdomain = false;
    public $adminPath = '/admin';

    public function __construct()
    {
        $host = parse_url(url('/'))['host'];
        if (strpos($host, 'admin') !== false) {
            $this->isAdminSubdomain = true;
            $this->adminPath = '';
        }
    }
}
