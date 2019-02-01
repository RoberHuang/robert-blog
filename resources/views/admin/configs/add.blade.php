@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row page-title-row">
            <div class="col-md-12">
                <h3>配置
                    <small>» 新增配置项</small>
                </h3>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">新增配置项表单</h3>
                    </div>
                    <div class="card-body">

                        @include('admin.partials.errors')

                        <form class="form-horizontal" role="form" method="POST" action="{{url('admin/configs')}}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group row">
                                <label for="name" class="col-md-3 control-label"><i class="require">*</i>名称</label>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" autofocus>
                                </div>
                            </div>

                            @include('admin.configs._form')

                            <div class="form-group row">
                                <div class="col-md-7 col-md-offset-3">
                                    <button type="submit" class="btn btn-primary btn-md">
                                        <i class="fa fa-plus-circle"></i>添加
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