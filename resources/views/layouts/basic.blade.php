<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $meta_description }}">
    <meta name="author" content="{{ config('blog.author') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('blog.title') }}</title>

    {{-- Styles --}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/basic.css') }}" rel="stylesheet">
    <link rel="alternate" type="application/rss+xml" href="{{ url('rss') }}" title="RSS Feed {{ config('blog.title') }}">
    @yield('styles')
</head>
<body>
<div id="app">
    @include('basic.partials.nav')
    @yield('page-header')
    @yield('content')
    @yield('comments')
    @include('blog.partials.page-footer')

    {{-- Scripts --}}
    <script src="{{ asset('js/app.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/common.js') }}"></script>
    @yield('scripts')
</div>
</body>
</html>