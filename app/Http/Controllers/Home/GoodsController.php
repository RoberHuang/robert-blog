<?php

namespace App\Http\Controllers\Home;

use App\Models\Goods;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GoodsController extends Controller
{
    public function index()
    {
        $goods = Goods::simplePaginate(config('blog.posts_per_page'));;

        return view('home.goods.index', compact('goods'));
    }
}
