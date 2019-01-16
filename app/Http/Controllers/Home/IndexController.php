<?php

namespace App\Http\Controllers\Home;

use App\Models\Admin\Tag;
use App\Models\Article;
use App\Services\ArticleService;
use App\Services\RssFeed;
use App\Services\SiteMap;
use Carbon\Carbon;
use Illuminate\Http\Request;

class IndexController extends CommonController
{
    public function index(Request $request)
    {
        $tag = $request->get('tag');

        $article_service = new ArticleService($tag);
        $data = $article_service->lists($tag);

        return view('blog.'. $this->layout .'.index', $data);
    }

    public function show(Request $request, $slug)
    {
        $article = Article::with('tags')->with('category')->where('slug', $slug)->firstOrFail();

        $tag = $request->get('tag');
        if ($tag)
            $tag = Tag::where('tag', $tag)->firstOrFail();

        $data = Article::where('cate_id', $article->cate_id)->orderBy('id','desc')->take(6)->get();

        return view('blog.'. $this->layout .'.article', compact('article', 'tag', 'data'));
    }

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
