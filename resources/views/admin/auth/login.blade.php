@extends('layouts.admin_login')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="text-center">
                        {{--<img src="{{URL::asset('/images/logo.png')}}" class="img-rounded" alt="Cinque Terre" width="136" height="56">--}}
                        <h3>{{{ config('blog.name') }}}</h3>
                    </div>
                </div>

                <div class="panel-body">
                    <form role="form" method="POST" action="{{ route('admin.login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="control-label">账号</label>

                            {{--<input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>--}}
                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="control-label">密码</label>

                            <input id="password" type="password" class="form-control" name="password" required>

                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary form-control">
                                登录
                            </button>
                        </div>
                        <div class="text-right">
                            <a class="btn-link" href="{{ route('admin.password.request') }}">
                                忘记密码
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            {{--<div class="panel panel-default">
                <div class="panel-body text-center">
                    @ 2018 Powered by stormenglish
                </div>
            </div>--}}
            <div class="content">
                <div class="links">
                    <a href="https://laravel.com/docs">Documentation</a>
                    <a href="https://laravel-news.com">News</a>
                    <a href="https://forge.laravel.com">Forge</a>
                    <a href="https://github.com/RoberHuang">GitHub</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
