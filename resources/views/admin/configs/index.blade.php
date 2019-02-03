@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row page-title-row">
            <div class="col-md-6">
                <h3>配置
                    <small>» 列表</small>
                </h3>
            </div>
            <div class="col-md-6 text-right">
                <a href="{{ route('configs.create') }}" class="btn btn-success btn-md">
                    <i class="fa fa-plus-circle"></i> 新增配置
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">

                @include('admin.partials.errors')
                @include('admin.partials.success')

                <form action="{{url('admin/configs/setConf')}}" method="post">
                    {{csrf_field()}}
                <table id="tags-table" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th class="text-center" width="4%">排序</th>
                        <th class="text-center" width="3%">ID</th>
                        <th>名称</th>
                        <th class="hidden-sm">标题</th>
                        <th class="hidden-md">内容</th>
                        <th data-sortable="false">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($data)>0)
                        @foreach ($data as $v)
                            <tr>
                                <td class="text-center">
                                    <input type="text" name="order[]" onchange="changeOrder(this,'{{ $v['id'] }}','{{url('admin/configs/setOrder')}}')" value="{{ $v['order'] }}" style="width:30px;text-align:center">
                                </td>
                                <td class="text-center">{{ $v['id'] }}</td>
                                <td>
                                    <a href="#">{{ $v['name'] }}</a>
                                </td>
                                <td>{{ $v['title'] }}</td>
                                <td>
                                    {!! $v['_html'] !!}
                                    <input type="hidden" name="conf_id[]" value="{{ $v['id'] }}"></td>
                                <td>
                                    <a href="{{url('admin/configs/'.$v['id'].'/edit')}}" class="btn btn-xs btn-info">
                                        <i class="fa fa-edit"></i> 编辑
                                    </a>
                                </td>
                            </tr>
                        @endforeach

                    @else
                        <tr><td class="text-center" colspan="6">暂无内容</td></tr>
                    @endif
                    </tbody>
                </table>
                <div class="form-group">
                    <button id="submit" type="submit" class="btn btn-sm btn-primary">保存配置</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@stop