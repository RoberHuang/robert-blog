<?php

namespace App\Http\Controllers\Home;

use App\Models\Article;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class CommonController extends Controller
{
    public $layout;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->layout = config('web.layout', 'basic');

        $hots = Article::where('published_at', '<=', Carbon::now())
            ->where('is_draft', 0)
            ->orderBy('article_frequency', 'desc')->orderBy('id', 'desc')
            ->take(5)->get();
        $news = Article::where('published_at', '<=', Carbon::now())
            ->where('is_draft', 0)
            ->orderBy('published_at', 'desc')->orderBy('id', 'desc')
            ->take(6)->get();

        View::share('hots', $hots);
        View::share('news', $news);
    }
}
