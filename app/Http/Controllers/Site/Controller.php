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
        $keywords = app('site')->keywords;
        $description = app('site')->description;
        $logo = getImageLogo(app('site')->icon);

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
            $image = getImage($par->cover);
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
            $socmed = null;
            $cacheSocmedName = 'cacheSocmedSEO';
            $cacheSocmed = \Cache::get($cacheSocmedName);
            if (!is_null($cacheSocmed) && $cacheSocmed != '-') {
                $socmed = $cacheSocmed;
            } else if (is_null($cacheSocmed)) {
                $socmed = \App\Models\SocmedData::where('type', 'site')->whereHas('socmed', function ($query) {
                    $query->where('name', 'Twitter');
                })->first();

                \Cache::put($cacheSocmedName, $socmed ?? '-', getCacheTime());
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

    public function generateUsername($user, $method = 1)
    {
        /* username from email */
        if ($method == 1) {
            $user_name = strtolower(explode("@", $user->email)[0]);
        }
        /* username from fullname, first word */
        else if ($method == 1) {
            $user_name = strtolower(explode(" ", $user->fullname)[0]);
        }
        /* username from fullname, remove space */
        else if ($method == 2) {
            $user_name = strtolower(str_replace(" ", "", $user->fullname));
        }
        /* username from fullname, change space to _ */
        else if ($method == 3) {
            $user_name = strtolower(str_replace(" ", "_", $user->fullname));
        }
        /* username from email with id */
        else if ($method == 4) {
            $user_name = strtolower(explode("@", $user->email)[0]);
            $user_name .= str_pad($user->id, 4, '0', STR_PAD_LEFT);
        }

        /* check existing */
        $exists = \App\Models\User::where('name', $user_name)->first();
        if ($exists) {
            return $this->generateUsername($user, $method += 1);
        }

        /* save user name */
        $user->name = $user_name;
        $user->save();

        return true;
    }
}
