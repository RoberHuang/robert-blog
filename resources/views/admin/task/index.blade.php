@extends('layouts.admin')

@section('content')
    <div class="container" id="app">
        <div class="row page-title-row">
            <div class="col-md-6">
                <h3>任务
                    <small>» 列表</small>
                </h3>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <h2 class="text-center">{{$user->name}} 的待办事项</h2>
                <tasks user="{{ $user->id }}"></tasks>
            </div>
        </div>
    </div>
@stop