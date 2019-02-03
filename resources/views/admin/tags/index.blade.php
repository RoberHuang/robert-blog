@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row page-title-row">
            <div class="col-md-6">
                <h3>标签
                    <small>» 列表</small>
                </h3>
            </div>
            <div class="col-md-6 text-right">
                <a href="{{ route('tags.create') }}" class="btn btn-success btn-md">
                    <i class="fa fa-plus-circle"></i> 新增标签
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <h5>Page {{ $meta['pagination']['current_page'] }} of {{ $meta['pagination']['total_pages'] }}</h5>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">

                @include('admin.partials.errors')
                @include('admin.partials.success')

                <table id="tags-table" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>名称</th>
                        <th>标题</th>
                        <th class="hidden-md">页面图片</th>
                        <th class="hidden-md">描述信息</th>
                        <th class="hidden-sm">排序</th>
                        <th data-sortable="false">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($data as $tag)
                        <tr>
                            <td>{{ $tag['name'] }}</td>
                            <td>{{ $tag['title'] }}</td>
                            <td class="hidden-md">{{ $tag['page_image'] }}</td>
                            <td class="hidden-md">{{ $tag['description'] }}</td>
                            <td class="hidden-sm">
                                @if ($tag['reverse_direction'])
                                    逆序
                                @else
                                    升序
                                @endif
                            </td>
                            <td>
                                <a href="/admin/tags/{{ $tag['id'] }}/edit" class="btn btn-xs btn-info">
                                    <i class="fa fa-edit"></i> 编辑
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @include('admin.partials.page')
    </div>
@stop