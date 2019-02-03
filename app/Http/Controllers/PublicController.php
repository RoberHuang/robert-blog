<?php

namespace App\Http\Controllers;

use App\Services\RssFeed;
use App\Services\SiteMap;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function rss(RssFeed $feed)
    {
        $rss = $feed->getRSS();

        return response($rss)->header('Content-type', 'application/rss+xml');
    }

    public function siteMap(SiteMap $siteMap)
    {
        $map = $siteMap->getSiteMap();

        return response($map)->header('Content-type', 'text/xml');
    }
}
