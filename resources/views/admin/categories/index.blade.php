@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row page-title-row">
            <div class="col-md-6">
                <h3>分类
                    <small>» 列表</small>
                </h3>
            </div>
            <div class="col-md-6 text-right">
                <a href="{{ route('categories.create') }}" class="btn btn-success btn-md">
                    <i class="fa fa-plus-circle"></i> 新增分类
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">

                @include('admin.partials.errors')
                @include('admin.partials.success')

                <table id="tags-table" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th class="text-center" width="4%">排序</th>
                        <th class="text-center" width="3%">ID</th>
                        <th>名称</th>
                        <th class="hidden-sm">标题</th>
                        <th class="hidden-md">层级</th>
                        <th data-sortable="false">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($categories)>0)
                        @foreach ($categories as $v)
                            <tr>
                                <td class="text-center">
                                    <input type="text" onchange="changeOrder(this,'{{ $v['id'] }}','{{url('admin/categories/setOrder')}}')"
                                           value="{{ $v['order'] }}" style="width:30px;text-align:center">
                                </td>
                                <td class="text-center">{{ $v['id'] }}</td>
                                <td>
                                    <a href="#">{{ $v['_name'] }}</a>
                                </td>
                                <td>{{ $v['title'] }}</td>
                                <td>{{ $v['level'] }}</td>
                                <td>
                                    <a href="{{url('admin/categories/'.$v['id'].'/edit')}}" class="btn btn-xs btn-info">
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
            </div>
        </div>
    </div>
@stop