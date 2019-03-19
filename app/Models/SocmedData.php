<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SocmedData extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'socmed_id';

    public function socmed()
    {
        return $this->belongsTo('App\Models\Socmed');
    }
}
