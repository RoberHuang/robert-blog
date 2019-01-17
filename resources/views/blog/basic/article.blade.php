@extends('layouts.basic', [
    'title' => $article->article_title,
    'meta_description' => $article->article_description ?? config('blog.description'),
])

@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/social-share.js/1.0.16/css/share.min.css" rel="stylesheet">
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header">
                    <ul class="breadcrumb" style="margin-bottom: 0">
                        <span class="glyphicon glyphicon-map-marker"></span>您当前的位置：
                        <li><a href="{{url('/')}}">首页</a></li>
                        <li>{!! join(', ', $article->tagLinks()) !!}</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center">
                <h2>{{ $article->article_title }}</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center">
                <p style="border: #ccc 1px dashed; margin-bottom: 20px; padding: 5px 0;">
                    <span class="glyphicon glyphicon-time" style="margin-right: 20px;">发布时间：{{ $article->published_at->format('Y-m-d') }}</span>
                    <span class="glyphicon glyphicon-user" style="margin-right: 20px;">作者：{{ $article->article_author }}</span>
                    <span class="glyphicon glyphicon-search">查看次数：{{ $article->article_frequency }}</span>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" style="text-indent: 2em">
                <div class="well">
                    {!! $article->content_html !!}
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-body">
                <span class="glyphicon glyphicon-tags"></span>关键字词：{!! join(' ', $article->keywordSpan()) !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @if ($tag && $tag->reverse_direction)
                    <p>上一篇：
                        @if ($article->olderPost($tag))
                            <a href="{!! $article->olderPost($tag)->url($tag) !!}">
                                {!! $article->olderPost($tag)->article_title !!}
                            </a>
                        @else
                            <span>没有上一篇了</span>
                        @endif
                    </p>
                    <p>下一篇：
                        @if ($article->newerPost($tag))
                            <a ref="{!! $article->newerPost($tag)->url($tag) !!}">
                                {!! $article->newerPost($tag)->article_title !!}
                            </a>
                        @else
                            <span>没有下一篇了</span>
                        @endif
                    </p>
                @else
                    <p>上一篇：
                        @if ($article->newerPost($tag))
                            <a href="{!! $article->newerPost($tag)->url($tag) !!}">
                                {!! $article->newerPost($tag)->article_title !!}
                            </a>
                        @else
                            <span>没有上一篇了</span>
                        @endif
                    </p>
                    <p>下一篇：
                        @if ($article->olderPost($tag))
                            <a href="{!! $article->olderPost($tag)->url($tag) !!}">
                                {!! $article->olderPost($tag)->article_title !!}
                            </a>
                        @else
                            <span>没有下一篇了</span>
                        @endif
                    </p>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="page-header" style="border-bottom: #099 2px solid;">
                    <spqn class="glyphicon glyphicon-book"></spqn>相关文章
                </div>
                <ul>
                    @foreach($data as $d)
                        <li><a href="{{ $d->url($tag) }}" title="{{$d->article_title}}">{{$d->article_title}}</a></li>
                    @endforeach
                </ul>
                <div class="social-share" data-mobile-sites="weibo,qq,qzone,tencent" data-disabled="google,twitter,facebook"
                     data-weibo-title="分享到微博-{{ $article->article_title }}" data-qq-title="分享到QQ"
                     data-wechat-qrcode-title="请打开微信扫一扫" data-description="一键分享到微博，QQ空间，腾讯微博，人人，豆瓣">
                </div>
            </div>
        </div>
        <hr>
    </div>
@stop
{{--{!! nl2br(e($article->article_content)) !!}--}}
@section('comments')
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                @include('blog.partials.disqus')
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/social-share.js/1.0.16/js/social-share.min.js"></script>
@stop