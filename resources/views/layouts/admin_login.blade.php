<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Admin</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('admins/css/is-login.admin.css') }}">
</head>
<body>
    <div id="app">
        <div class="flex-center position-ref full-height">
            @if (Route::has('admin.login'))
                <div class="top-right links">
                    <a href="{{ url('/') }}">网站首页</a>
                    <a href="{{ route('admin.login') }}" class="dropdown dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        语言选择 <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu pull-right" role="menu">
                        {{--@foreach(Config::get('app.locales') as $l => $lang)--}}
                            {{--@if($l != App::getLocale())--}}
                            <li><a href="#">中文</a></li>
                            {{--@endif--}}
                        {{--@endforeach--}}
                    </ul>
                </div>
            @endif
        </div>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
