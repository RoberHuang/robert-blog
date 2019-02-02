@extends('layouts.basic', [
    'title' => 'goods',
    'meta_description' => '商品页面',
])

@section('page-header')
    <header class="masthead">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-10 mx-auto">
                    <div class="site-heading">
                        <h1>Goods</h1>
                        <span class="subheading">Goods</span>
                    </div>
                </div>
            </div>
        </div>
    </header>
@stop

@section('content')
    <div class="container">
        <div class="row">

                @foreach($goods['data'] as $gd)
                    <div class="col-md-4">
                        <article>
                            <img src="{{ $gd['image'] }}" alt="">
                            <h1>{{ $gd['subject'] }}</h1>
                        </article>
                        <a href="/buy/{{ $gd['id'] }}" class="btn btn-block btn-success">立即购买</a>
                    </div>
                @endforeach
            <div class="col-lg-8 col-md-10 ">
                {{-- 分页 --}}
                <div class="clearfix">
                    @if ($goods['meta']['pagination']['current_page'] > 1)
                        <a class="btn btn-primary float-left" href="{{ $goods['meta']['pagination']['links']['previous'] }}">
                            ←
                            Newer Goods
                        </a>
                    @endif
                    @if ($goods['meta']['pagination']['current_page'] < $goods['meta']['pagination']['total_pages'])
                        <a class="btn btn-primary float-right" href="{{ $goods['meta']['pagination']['links']['next'] }}">
                            Older Goods
                            →
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop

@section('comments')
    <script id="dsq-count-scr" src="//blog-com-5.disqus.com/count.js" async></script>
@stop