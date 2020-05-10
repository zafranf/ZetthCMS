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
        $tagline = app('site')->tagline;
        $sitetag = !empty($tagline) ? $sitename . ' - ' . $tagline : $sitename;
        $title = !empty($title) ? $title . $separator . $sitetag : $sitetag;
        $keywords = app('site')->keywords;
        $description = app('site')->description;
        $logo = getImageLogo(app('site')->icon);
        $language = app('site')->language;

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
        OpenGraph::addProperty('locale', $language);

        if (!empty($par) && $par->type == "article") {
            $type = 'article';
            $cats = [];
            $tags = [];
            $time = $par->published_at != "0000-00-00 00:00:00" ? $par->published_at : $par->created_at;

            /* set tags and categories */
            $terms = \Cache::remember('cacheTermsSEO' . app('site')->id, getCacheTime(), function () use ($par) {
                return $par->terms ?? [];
            });
            foreach ($terms as $k => $v) {
                if ($v->type == "tag") {
                    $tags[] = $v->name;
                }
                if ($v->type = "category") {
                    $cats[] = $v->name;
                }
            }

            $title = $par->title . $separator . $sitename;
            $image = getImage($par->cover);
            $keywords = implode(',', $tags);
            $description = \Str::limit(strip_tags($par->content), 255);
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
            $socmed = \Cache::remember('cacheSocmedSEO' . app('site')->id, getCacheTime(), function () {
                return \App\Models\SocmedData::where('socmedable_type', 'App\Models\Site')->whereHas('socmed', function ($query) {
                    $query->where('name', 'Twitter');
                })->first() ?? '-';
            });

            if ($socmed != '-') {
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

    public function generateUsername($user, $method = 1)
    {
        /* username from email */
        if ($method == 1) {
            $user_name = strtolower(explode("@", $user->email)[0]);
        }
        /* username from fullname, first word */
        else if ($method == 2) {
            $user_name = strtolower(explode(" ", $user->fullname)[0]);
        }
        /* username from fullname, remove space */
        else if ($method == 3) {
            $user_name = strtolower(str_replace(" ", "", $user->fullname));
        }
        /* username from fullname, change space to _ */
        else if ($method == 4) {
            $user_name = strtolower(str_replace(" ", "_", $user->fullname));
        }
        /* username from email with id */
        else if ($method == 5) {
            $user_name = strtolower(explode("@", $user->email)[0]);
            $user_name .= str_pad($user->id, 4, '0', STR_PAD_LEFT);
        }

        /* check existing */
        $exists = \App\Models\User::where('name', _encrypt($user_name))->first();
        if ($exists) {
            return $this->generateUsername($user, $method += 1);
        }

        /* save user name */
        $user->name = $user_name;
        $user->save();

        return $user;
    }
}
