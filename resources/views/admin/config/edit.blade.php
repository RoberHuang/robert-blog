@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row page-title-row">
            <div class="col-md-12">
                <h3>配置
                    <small>» 编辑配置项</small>
                </h3>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">编辑配置项表单</h3>
                    </div>
                    <div class="card-body">

                        @include('admin.partials.errors')
                        @include('admin.partials.success')

                        <form class="form-horizontal" role="form" method="POST" action="{{url('admin/config/'.$id)}}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" name="id" value="{{ $id }}">

                            <div class="form-group row">
                                <label for="name" class="col-md-3 control-label"><i class="require">*</i>名称</label>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" name="name" id="name" value="{{ $name }}" autofocus>
                                </div>
                            </div>

                            @include('admin.config._form')

                            <div class="form-group row">
                                <div class="col-md-7 col-md-offset-3">
                                    <button type="submit" class="btn btn-primary btn-md">
                                        <i class="fa fa-plus-circle"></i>修改
                                    </button>
                                    <button type="button" class="btn btn-danger btn-md" data-toggle="modal" data-target="#modal-delete">
                                        <i class="fa fa-times-circle"></i>删除
                                    </button>
                                    <button type="button" class="btn btn-default btn-md" onclick="history.go(-1)">
                                        <i class="fa fa-plus-circle"></i>返回
                                    </button>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 确认删除 --}}
    <div class="modal fade" id="modal-delete" tabIndex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        ×
                    </button>
                    <h4 class="modal-title">请确认</h4>
                </div>
                <div class="modal-body">
                    <p class="lead">
                        <i class="fa fa-question-circle fa-lg"></i>
                        确定要删除这个配置项?
                    </p>
                </div>
                <div class="modal-footer">
                    <form method="POST" action="{{url('admin/config/'.$id)}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fa fa-times-circle"></i> 确认
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script>
        showTr();
        function showTr() {
            var type = $('input[name=type]:checked').val();
            if(type == 'radio'){
                $('.value').show();
            }else{
                $('.value').hide();
            }
        }
    </script>
@stop