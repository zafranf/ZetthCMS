<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostComment extends Model
{
    use SoftDeletes;

    public function post()
    {
        return $this->belongsTo('App\Http\Models\Post');
    }

    public function approval()
    {
        return $this->belongsTo('App\Http\Models\User', 'approved_by');
    }
}
