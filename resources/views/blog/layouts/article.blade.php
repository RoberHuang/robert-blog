@extends('layouts.blog', [
    'title' => $article->article_title,
    'meta_description' => $article->article_description ?? config('blog.description'),
])

@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/social-share.js/1.0.16/css/share.min.css" rel="stylesheet">
@stop

@section('page-header')
    <header class="masthead" style="background-image: url('{{ page_image($article->article_thumb ?? config('blog.page_image')) }}')">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-10 mx-auto">
                    <div class="post-heading">
                        <h1>{{ $article->article_title }}</h1>
                        <h2 class="subheading">{{ $article->subtitle }}</h2>
                        <span class="meta">
                            Posted on {{ $article->published_at->format('Y-m-d') }}
                            @if ($article->tags->count())
                                in
                                {!! join(', ', $article->tagLinks()) !!}
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </header>
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                <article>
                    {!! $article->content_html !!}
                </article>
                <hr>
                <div class="clearfix">
                    @if ($tag && $tag->reverse_direction)
                        @if ($article->olderPost($tag))
                            <a class="btn btn-primary float-left" href="{!! $article->olderPost($tag)->url($tag) !!}">
                                ←
                                Previous {{ $tag->tag }} Post
                            </a>
                        @endif
                        @if ($article->newerPost($tag))
                            <a class="btn btn-primary float-right" ref="{!! $article->newerPost($tag)->url($tag) !!}">
                                Next {{ $tag->tag }} Post
                                →
                            </a>
                        @endif
                    @else
                        @if ($article->newerPost($tag))
                            <a class="btn btn-primary float-left" href="{!! $article->newerPost($tag)->url($tag) !!}">
                                ←
                                Newer {{ $tag ? $tag->tag : '' }} Post
                            </a>
                        @endif
                        @if ($article->olderPost($tag))
                            <a class="btn btn-primary float-right" href="{!! $article->olderPost($tag)->url($tag) !!}">
                                Older {{ $tag ? $tag->tag : '' }} Post
                                →
                            </a>
                        @endif
                    @endif
                </div>
                <hr>
                <div class="social-share" data-mobile-sites="weibo,qq,qzone,tencent" data-disabled="google,twitter,facebook"
                     data-weibo-title="分享到微博-{{ $article->article_title }}" data-qq-title="分享到QQ"
                     data-wechat-qrcode-title="请打开微信扫一扫" data-description="一键分享到微博，QQ空间，腾讯微博，人人，豆瓣">
                </div>
            </div>
        </div>
    </div>
@stop
    {{--{!! nl2br(e($article->article_content)) !!}--}}
@section('comments')
    <hr>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                @include('blog.partials.disqus')
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/social-share.js/1.0.16/js/social-share.min.js"></script>
@stop