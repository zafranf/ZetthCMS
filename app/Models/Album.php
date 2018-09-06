<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Album extends Model
{
    use SoftDeletes;

    public function photo()
    {
        return $this->hasOne('App\Http\Models\AlbumDetail', 'album_id')->where('type', 'photo');
    }

    public function photos()
    {
        return $this->hasMany('App\Http\Models\AlbumDetail', 'album_id')->where('type', 'photo');
    }
}
