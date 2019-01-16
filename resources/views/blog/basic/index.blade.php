@extends('layouts.basic')

@section('page-header')
    <div class="banner">
        <section class="box">
            <ul class="texts">
                <p>拼搏</p>
                <p>犹如大风暴雨过境</p>
            </ul>
            <div class="avatar"><a href="#"><span>Robert</span></a> </div>
        </section>
    </div>
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                @foreach($articles as $article)
                    <div class="page-header">
                        <a href="{{ $article->url($tag) }}">
                            <h3>{{$article->article_title}}</h3>
                        </a>
                    </div>

                    <div class="row">
                        <div class="col-sm-6 col-md-3">
                            <a href="{{ $article->url($tag) }}" class="thumbnail">
                                <img src="{{page_image($article->article_thumb ? $article->article_thumb : config('blog.article_thumb'))}}">
                            </a>
                        </div>
                        <div class="col-sm-6 col-md-9">
                            <a href="{{ $article->url($tag) }}">
                                @if($article->subtitle)
                                    <p class="post-subtitle" style="font-weight: bold;"> {{ $article->subtitle }}</p>
                                @endif
                                <p>{{$article->art_description}}</p>
                            </a>
                            {{--<a title="{{$article->article_title}}" href="{{  $article->url($tag) }}" target="_blank" class="readmore">阅读全文>></a>--}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <span class="glyphicon glyphicon-time" style="margin-right: 20px;">发布于：{{ $article->published_at->format('Y-m-d') }}</span>
                            <span class="glyphicon glyphicon-tags" style="margin-right: 20px;">
                                @if ($article->tags->count())
                                    标签：
                                    {!! join(', ', $article->tagLinks()) !!}
                                @endif
                                <a href="{{ $article->url($tag) }}#disqus_thread"></a>
                            </span>
                            <span class="glyphicon glyphicon-user">作者：{{$article->article_author}}</span>
                        </div>
                    </div>
                @endforeach
                <div class="page">
                    <ul class="pagination">
                        @if ($reverse_direction)
                            @if ($articles->currentPage() > 1)
                                <li>
                                    <a href="{!! $articles->url($articles->currentPage() - 1) !!}">
                                        ←
                                        Previous {{ $tag->tag }} Posts
                                    </a>
                                </li>
                            @endif
                            @if ($articles->hasMorePages())
                                <li>
                                    <a href="{!! $articles->nextPageUrl() !!}">
                                        Next {{ $tag->tag }} Posts
                                        →
                                    </a>
                                </li>
                            @endif
                        @else
                            @if ($articles->currentPage() > 1)
                                <li>
                                    <a href="{!! $articles->url($articles->currentPage() - 1) !!}">
                                        ←
                                        Newer {{ $tag ? $tag->tag : '' }} Posts
                                    </a>
                                </li>
                            @endif
                            @if ($articles->hasMorePages())
                                <li>
                                    <a href="{!! $articles->nextPageUrl() !!}">
                                        Older {{ $tag ? $tag->tag : '' }} Posts
                                        →
                                    </a>
                                </li>
                            @endif
                        @endif
                    </ul>
                </div>
            </div>
            <div class="col-md-3">
                <div class="page-header">
                    <h3>
                        <p>最新<span>文章</span></p>
                    </h3>
                </div>
                <ul>
                    @foreach($news as $new)
                        <li><a href="{{ $new->url($tag) }}" title="{{$new->article_title}}" target="_blank">{{ $new->article_title }}</a></li>
                    @endforeach
                </ul>
                <div class="page-header">
                    <h3>
                        <p>点击<span>排行</span></p>
                    </h3>
                </div>
                <ul class="paih">
                    @foreach($hots as $hot)
                        <li><a href="{{ $hot->url($tag)}}" title="{{$hot->article_title}}" target="_blank">{{$hot->article_title}}</a></li>
                    @endforeach
                </ul>
                {{--<div class="page-header">
                    <h3>
                        <p>友情<span>链接</span></p>
                    </h3>
                </div>--}}
            </div>
        </div>
    </div>
@stop

@section('comments')
    <script id="dsq-count-scr" src="//blog-com-5.disqus.com/count.js" async></script>
@stop