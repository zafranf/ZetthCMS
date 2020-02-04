<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Site\Controller;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function album(Request $r)
    {
        /* set breadcrumbs */
        $this->breadcrumbs[] = [
            'page' => 'Album',
            'icon' => '',
            'url' => '',
        ];

        /* set data */
        $data = [
            'page_title' => 'Album Sekolah',
            'breadcrumbs' => $this->breadcrumbs,
            'albums' => _getAlbums(),
        ];

        /* Set SEO */
        $this->setSEO($data['page_title']);

        return view($this->getTemplate() . '.albums', $data);
    }

    public function album_detail(Request $r, $slug)
    {
        /* get photos */
        $album = \ZetthCore\Models\Album::active()->where('slug', $slug)->with('photos')->first();
        if (!$album) {
            abort(404);
        }

        /* set breadcrumbs */
        $this->breadcrumbs[] = [
            'page' => 'Album',
            'icon' => '',
            'url' => url('/albums'),
        ];
        $this->breadcrumbs[] = [
            'page' => $album->name,
            'icon' => '',
            'url' => '',
        ];

        /* set data */
        $data = [
            'page_title' => $album->name,
            'breadcrumbs' => $this->breadcrumbs,
            'album' => $album,
        ];

        /* Set SEO */
        $this->setSEO($data['page_title']);

        return view($this->getTemplate() . '.album', $data);
    }

    public function video(Request $r)
    {
        /* set breadcrumbs */
        $this->breadcrumbs[] = [
            'page' => 'Video',
            'icon' => '',
            'url' => '',
        ];

        /* set data */
        $data = [
            'page_title' => 'Video Sekolah',
            'breadcrumbs' => $this->breadcrumbs,
            'videos' => _getVideos(),
        ];

        /* Set SEO */
        $this->setSEO($data['page_title']);

        return view($this->getTemplate() . '.videos', $data);
    }

    public function video_detail(Request $r, $slug)
    {
        /* get photos */
        $video = \ZetthCore\Models\Post::videos()->active()->where('slug', $slug)->first();
        if (!$video) {
            abort(404);
        }

        /* set breadcrumbs */
        $this->breadcrumbs[] = [
            'page' => 'Video',
            'icon' => '',
            'url' => url('/videos'),
        ];
        $this->breadcrumbs[] = [
            'page' => $video->title,
            'icon' => '',
            'url' => '',
        ];

        /* set data */
        $data = [
            'page_title' => $video->title,
            'breadcrumbs' => $this->breadcrumbs,
            'video' => $video,
        ];

        /* Set SEO */
        $this->setSEO($data['page_title']);

        return view($this->getTemplate() . '.video', $data);
    }
}
