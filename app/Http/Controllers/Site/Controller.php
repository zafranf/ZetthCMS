<?php

namespace App\Http\Controllers\Site;

use OpenGraph;
use SEOMeta;
use Twitter;
use ZetthCore\Http\Controllers\SiteController;

class Controller extends SiteController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function setSEO($title = '', $par = [])
    {
        $separator = config('seotools.meta.defaults.separator');
        $url = url()->current();
        $sitename = app('site')->name;
        $title = !empty($title) ? $title . $separator . $sitename : $sitename;
        $tagline = app('site')->tagline;
        $keywords = app('site')->keyword;
        $description = app('site')->description;
        $logo = _get_image("assets/images/" . app('site')->icon);

        /* Set General SEO */
        SEOMeta::setTitle($title);
        if ($keywords) {
            SEOMeta::setKeywords($keywords);
        }
        if ($description) {
            SEOMeta::setDescription($description);
        }

        /* Set OpenGraph SEO */
        OpenGraph::setTitle($title);
        if ($description) {
            OpenGraph::setDescription($description);
        }
        OpenGraph::setType('website');
        OpenGraph::setUrl($url);
        OpenGraph::setSiteName($sitename);
        OpenGraph::addProperty('locale', 'id_ID');

        if (!empty($par) && $par->type == "article") {
            $type = 'article';
            $cats = [];
            $tags = [];
            $time = $par->published_at != "0000-00-00 00:00:00" ? $par->published_at : $par->created_at;

            /* set tags and categories */
            $cacheTermsName = 'cacheTermsSEO';
            $cacheTerms = \Cache::get($cacheTermsName);
            if ($cacheTerms) {
                $terms = $cacheTerms;
            } else {
                $terms = $par->terms;

                \Cache::put($cacheTermsName, $terms, getCacheTime());
            }
            foreach ($terms as $k => $v) {
                if ($v->type == "tag") {
                    $tags[] = $v->name;
                }
                if ($v->type = "category") {
                    $cats[] = $v->name;
                }
            }

            $title = $par->title . $separator . $sitename;
            $image = _get_image($par->cover);
            $keywords = implode(',', $tags);
            $description = \Str::limit(strip_tags($par->content), 300);
            if (strlen($par->excerpt) > 0) {
                $description = strip_tags($par->excerpt);
            }

            /* Set General SEO */
            SEOMeta::setTitle($title);
            if ($keywords) {
                SEOMeta::setKeywords($keywords);
            }
            if ($description) {
                SEOMeta::setDescription($description);
            }

            /* Set OpenGraph SEO */
            OpenGraph::setTitle($title);
            if ($description) {
                OpenGraph::setDescription($description);
            }
            OpenGraph::setType($type);
            OpenGraph::addImage($image);
            OpenGraph::setArticle([
                'tag' => $tags ?? '',
                'published_time' => date('c', strtotime($time)),
                'author' => $par->author->fullname,
                'section' => $cats[0] ?? '',
            ]);

            /* twitter card */
            $cacheSocmedName = 'cacheSocmedSEO';
            $cacheSocmed = \Cache::get($cacheSocmedName);
            if ($cacheSocmed) {
                $socmed = $cacheSocmed;
            } else {
                $socmed = \ZetthCore\Models\SocmedData::where('type', 'site')->whereHas('socmed', function (\Illuminate\Database\Eloquent\Builder $query) {
                    $query->where('name', 'Twitter');
                })->first();

                \Cache::put($cacheSocmedName, $socmed, getCacheTime());
            }
            if ($socmed) {
                /* Set Twitter SEO */
                Twitter::addValue('card', 'summary');
                Twitter::setImage($image);
                Twitter::setType($type);
                Twitter::setTitle($title);
                Twitter::setSite($socmed->username);
                Twitter::setDescription($description);
                Twitter::setUrl($url);
            }
        } else {
            OpenGraph::addImage($logo);
        }
    }
}
