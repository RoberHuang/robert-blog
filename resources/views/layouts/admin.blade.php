<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('blog.title', 'blog') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('admins/css/style.css') }}" rel="stylesheet">

    @yield('styles')
</head>
<body>
{{-- Navigation Bar--}}
<nav class="navbar navbar-expand-md navbar-light nav-laravel">
    <div class="container">
        <a class="navbar-brand mr-auto mr-lg-0" href="#">{{ config('blog.title', 'blog') }} 后台</a>


        <!-- Collapsed Hamburger -->
        <button type="button" class="navbar-toggle p-0 border-0" type="button" data-toggle="collapse" data-target="#app-navbar-collapse"
                aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            @include('admin.partials.navbar')
        </div>
    </div>
</nav>

<main class="py-4" id="app">
    @yield('content')
</main>
<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
<script type="text/javascript" src="{{ asset('admins/js/common.js') }}"></script>

@yield('scripts')
</body>
</html>
