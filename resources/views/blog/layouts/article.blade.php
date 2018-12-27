@extends('layouts.blog', [
    'title' => $article->title,
    'meta_description' => $article->article_description ?? config('blog.description'),
])
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
            </div>
        </div>
    </div>
<html>
@stop
    {{--{!! nl2br(e($article->article_content)) !!}--}}
