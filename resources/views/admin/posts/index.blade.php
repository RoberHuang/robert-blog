@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row page-title-row">
            <div class="col-md-6">
                <h3>文章 <small>» 列表</small></h3>
            </div>
            <div class="col-md-6 text-right">
                <a href="{{ route('posts.create') }}" class="btn btn-success btn-md">
                    <i class="fa fa-plus-circle"></i> 创建新文章
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

                <table id="posts-table" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>标题</th>
                        <th>分类</th>
                        <th>发布时间</th>
                        <th data-sortable="false">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($data)>0)
                        @foreach ($data as $post)
                            <tr>
                                <td>{{ $post['title'] }}</td>
                                <td>{{ $post['category']['name'] }}</td>
                                <td data-order="{{ $post['published_at'] }}">
                                    {{ $post['published_at'] }}
                                </td>
                                <td>
                                    <a href="/admin/posts/{{ $post['id'] }}/edit" class="btn btn-xs btn-info">
                                        <i class="fa fa-edit"></i> 编辑
                                    </a>
                                    <a href="/index/{{ $post['slug'] }}" class="btn btn-xs btn-warning">
                                        <i class="fa fa-eye"></i> 查看
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr><td class="text-center" colspan="4">暂无内容</td></tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
        @include('admin.partials.page')
    </div>
@endsection