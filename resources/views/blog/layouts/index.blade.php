@extends('layouts.blog')

@section('page-header')
    <header class="masthead" style="background-image: url('{{ page_image($page_image) }}')">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-10 mx-auto">
                    <div class="site-heading">
                        <h1>{{ $title }}</h1>
                        <span class="subheading">{{ $subtitle }}</span>
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
                @foreach($articles as $article)
                    <div class="post-preview">
                        <a href="{{ $article->url($tag) }}">
                            <h2 class="post-title"> {{ $article->article_title }}</h2>
                            @if($article->subtitle)
                                <h3 class="post-subtitle"> {{ $article->subtitle }}</h3>
                            @endif
                        </a>
                        <p class="post-meta">
                            Posted on {{ $article->published_at->format('Y-m-d') }}
                            @if ($article->tags->count())
                                in
                                {!! join(', ', $article->tagLinks()) !!}
                            @endif
                            <a href="{{ $article->url($tag) }}#disqus_thread"></a>
                        </p>
                    </div>
                    <hr>
                @endforeach

                {{-- 分页 --}}
                <div class="clearfix">
                    @if ($reverse_direction)
                        @if ($articles->currentPage() > 1)
                            <a class="btn btn-primary float-left" href="{!! $articles->url($articles->currentPage() - 1) !!}">
                                ←
                                Previous {{ $tag->tag }} Posts
                            </a>
                        @endif
                        @if ($articles->hasMorePages())
                            <a class="btn btn-primary float-right" href="{!! $articles->nextPageUrl() !!}">
                                Next {{ $tag->tag }} Posts
                                →
                            </a>
                        @endif
                    @else
                        @if ($articles->currentPage() > 1)
                            <a class="btn btn-primary float-left" href="{!! $articles->url($articles->currentPage() - 1) !!}">
                                ←
                                Newer {{ $tag ? $tag->tag : '' }} Posts
                            </a>
                        @endif
                        @if ($articles->hasMorePages())
                            <a class="btn btn-primary float-right" href="{!! $articles->nextPageUrl() !!}">
                                Older {{ $tag ? $tag->tag : '' }} Posts
                                →
                            </a>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop

@section('comments')
    <script id="dsq-count-scr" src="//blog-com-5.disqus.com/count.js" async></script>
@stop