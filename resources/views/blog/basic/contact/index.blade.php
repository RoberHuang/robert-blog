@extends('layouts.basic', ['meta_description' => '联系我们'])

@section('page-header')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header">
                    <h1>联系我们</h1>
                    <span class="subheading">填写下面的表单给我发消息，我会尽快给你回复！</span>
                </div>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                @include('admin.partials.errors')
                @include('admin.partials.success')
                <form name="sentMessage" action="/contact" method="post" novalidate>
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                    <div class="form-group">
                        <label for="name">姓名</label>
                        <input type="text" name="name" class="form-control" placeholder="填写你的名字" id="name" value="{{ old('name') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="email">邮箱</label>
                        <input type="email" name="email" class="form-control" placeholder="填写你的邮箱" id="email" value="{{ old('email') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="tel">手机</label>
                        <input type="tel" name="phone" class="form-control" placeholder="填写你的手机号" id="phone" value="{{ old('phone') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="message">消息</label>
                        <textarea rows="5" name="message" class="form-control" placeholder="填写你想发送的消息" id="message" value="{{ old('message') }}" required></textarea>
                    </div>
                    <br>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">发送</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
