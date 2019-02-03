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
                @foreach($posts['data'] as $post)
                    <div class="page-header">
                        <a href="@if($tag) {{ Request::url().'/'.$post['slug'].'?tag='.$tag['name'] }} @else {{ Request::url().'/'.$post['slug'] }} @endif">
                            <h3>{{ $post['title'] }}</h3>
                        </a>
                    </div>

                    <div class="row">
                        <div class="col-sm-6 col-md-3">
                            <a href="@if($tag) {{ Request::url().'/'.$post['slug'].'?tag='.$tag['name'] }} @else {{ Request::url().'/'.$post['slug'] }} @endif" class="thumbnail">
                                <img src="{{page_image($post['thumbnail'] ? $post['thumbnail'] : config('blog.article_thumb'))}}">
                            </a>
                        </div>
                        <div class="col-sm-6 col-md-9">
                            <a href="@if($tag) {{ Request::url().'/'.$post['slug'].'?tag='.$tag['name'] }} @else {{ Request::url().'/'.$post['slug'] }} @endif">
                                @if($post['subtitle'])
                                    <p style="font-weight: bold;"> {{ $post['subtitle'] }}</p>
                                @endif
                                <p>{{ $post['description'] }}</p>
                            </a>
                            {{--<a title="{{$post->article_title}}" href="{{  $post->url($tag) }}" target="_blank" class="readmore">阅读全文>></a>--}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <span class="glyphicon glyphicon-time" style="margin-right: 20px;">发布于：{{ $post['published_at'] }}</span>
                            @if (count($post['tags']))
                                <span class="glyphicon glyphicon-tags" style="margin-right: 20px;">标签：
                                    @foreach($post['tags'] as $t)
                                        <a href="?tag={{ $t['name'] }}">{{ $t['name'] }}</a>
                                    @endforeach
                                </span>
                            @endif
                            <span class="glyphicon glyphicon-user">作者：{{ $post['user']['name'] }}</span>
                            <a href="@if($tag) {{ Request::url().'/'.$post['slug'].'?tag='.$tag['name'] }} @else {{ Request::url().'/'.$post['slug'] }} @endif#disqus_thread"></a>
                        </div>
                    </div>
                @endforeach
                <div class="page">
                    <ul class="pagination">
                        @if ($posts['meta']['pagination']['current_page'] > 1)
                            <li>
                                <a href="{{ $posts['meta']['pagination']['links']['previous'] }}">
                                    上一页 {{ $tag ? '[ '.$tag['name'].' ]' : '' }}
                                </a>
                            </li>
                        @endif
                        @if ($posts['meta']['pagination']['current_page'] < $posts['meta']['pagination']['total_pages'])
                            <li>
                                <a href="{{ $posts['meta']['pagination']['links']['next'] }}">
                                    下一页 {{ $tag ? '[ '.$tag['name'].' ]' : '' }}
                                </a>
                            </li>
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
                        <li><a href="@if($tag) {{ Request::url().'/'.$new['slug'].'?tag='.$tag['name'] }} @else {{ Request::url().'/'.$new['slug'] }} @endif" title="{{ $new['title'] }}" target="_blank">{{ $new['title'] }}</a></li>
                    @endforeach
                </ul>
                <div class="page-header">
                    <h3>
                        <p>点击<span>排行</span></p>
                    </h3>
                </div>
                <ul class="paih">
                    @foreach($hots as $hot)
                        <li><a href="@if($tag) {{ Request::url().'/'.$hot['slug'].'?tag='.$tag['name'] }} @else {{ Request::url().'/'.$hot['slug'] }} @endif" title="{{ $hot['title'] }}" target="_blank">{{ $hot['title'] }}</a></li>
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
    <script id="dsq-count-scr" src="//stormenglish.disqus.com/count.js" async></script>
@stop