@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row page-title-row">
            <div class="col-md-6">
                <h3>任务
                    <small>» 列表</small>
                </h3>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <h2 class="text-center">{{$project->name}} 的待办事项</h2>
                <tasks project="{{ $project->id }}"></tasks>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    {{--<script src="//{{ Request::getHost() }}:6001/socket.io/socket.io.js"></script>--}}
@stop