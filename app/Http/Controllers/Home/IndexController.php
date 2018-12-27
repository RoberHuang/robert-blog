<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Admin\Tag;
use App\Models\Article;
use App\Services\ArticleService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        $tag = $request->get('tag');

        $article_service = new ArticleService($tag);
        $data = $article_service->lists($tag);
        $layout = $tag ? Tag::layout($tag) : 'blog.layouts.index';

        return view($layout, $data);
    }

    public function show(Request $request, $slug)
    {
        $article = Article::with('tags')->with('category')->where('slug', $slug)->firstOrFail();

        $tag = $request->get('tag');
        if ($tag)
            $tag = Tag::where('tag', $tag)->firstOrFail();

        return view($article->layout, compact('article', 'tag'));
    }
}
