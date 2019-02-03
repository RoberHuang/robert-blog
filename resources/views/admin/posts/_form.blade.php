<div class="row">
    <div class="col-md-8">
        <div class="form-group row">
            <label for="title" class="col-md-2 control-label">
                <i class="require">*</i>标题
            </label>
            <div class="col-md-10">
                <input type="text" class="form-control" name="title" autofocus id="title" value="{{ old('title', $data['title'] ?? '') }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="subtitle" class="col-md-2 control-label">
                <i class="require">*</i>副标题
            </label>
            <div class="col-md-10">
                <input type="text" class="form-control" name="subtitle" id="subtitle" value="{{ old('subtitle', $data['subtitle'] ?? '') }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="thumbnail" class="col-md-2 control-label">
                缩略图
            </label>
            <div class="col-md-10">
                <div class="row">
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="thumbnail" id="thumbnail" onchange="handle_image_change()" 
                               alt="Image thumbnail" value="{{ old('thumbnail', $data['thumbnail'] ?? config('blog.page_image')) }}">
                    </div>
                    <script>
                        function handle_image_change() {
                            $("#page-image-preview").attr("src", function () {
                                var value = $("#thumbnail").val();
                                if ( ! value) {
                                    value = {!! json_encode(config('blog.page_image')) !!};
                                    if (value == null) {
                                        value = '';
                                    }
                                }
                                if (value.substr(0, 4) != 'http' && value.substr(0, 1) != '/') {
                                    value = {!! json_encode(config('blog.uploads.webpath')) !!} + '/' + value;
                                }
                                return value;
                            });
                        }
                    </script>
                    <div class="visible-sm space-10"></div>
                    <div class="col-md-4 text-right">
                        <img src="{{ page_image(old('thumbnail', $data['thumbnail'] ?? config('blog.page_image'))) }}" class="img img_responsive" id="page-image-preview" style="max-height:40px">
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="content" class="col-md-2 control-label">
                <i class="require">*</i>内容
            </label>
            <div class="col-md-10">
                <textarea class="form-control" name="content" rows="10" id="content">{{ old('content', $data['content'] ?? '') }}</textarea>
            </div>
        </div>
        <div class="form-group row">
            <label for="keyword" class="col-md-2 control-label">
                关键词
            </label>
            <div class="col-md-10">
                <input type="text" class="form-control" name="keyword" id="keyword" value="{{ old('keyword', $data['keyword'] ?? '') }}">
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group row">
            <label for="category_id" class="col-md-4 control-label"><i class="require">*</i>分类</label>
            <div class="col-md-8">
                <select class="form-control" name="category_id" autofocus>
                    <option value="0">==顶级分类==</option>
                    @foreach($categories as $category)
                        <option value="{{ $category['id'] }}" @if ($category['id'] == old('category_id', $data['category_id'] ?? 0)) selected @endif >
                            {{ $category['_name'] }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="publish_date" class="col-md-4 control-label">
                <i class="require">*</i>发布日期
            </label>
            <div class="col-md-8">
                <input class="form-control" name="publish_date" id="publish_date" type="text"
                    @if (isset($data['published_at']) && !empty($data['published_at']))
                        value="{{ old('publish_date',  date('Y-m-d', strtotime($data['published_at']))) }}"
                    @else
                        value="{{ old('publish_date',  date('Y-m-d', time())) }}"
                    @endif
                >
            </div>
        </div>
        <div class="form-group row">
            <label for="publish_time" class="col-md-4 control-label">
                <i class="require">*</i>发布时间
            </label>
            <div class="col-md-8">
                <input class="form-control" name="publish_time" id="publish_time" type="text"
                       @if (isset($data['published_at']) && !empty($data['published_at']))
                       value="{{ old('publish_time',  date('g:i A', strtotime($data['published_at']))) }}"
                       @else
                       value="{{ old('publish_time',  date('g:i A', time() + 3600)) }}"
                       @endif
                >
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-8 col-md-offset-4">
                <div class="checkbox">
                    <label>
                        <input {{ checked(old('is_draft', $data['is_draft'] ?? false)) }} type="checkbox" name="is_draft">
                        草稿?
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="tags" class="col-md-4 control-label">
                标签
            </label>
            <div class="col-md-8">
                <select name="tags[]" id="tag_ids" class="form-control" multiple>
                    @foreach ($allTags['data'] as $tag)
                        <option @if (in_array($tag['id'], old('tags', $data['tags'] ?? []))) selected @endif value="{{ $tag['id'] }}">
                            {{ $tag['name'] }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="description" class="col-md-4 control-label">
                摘要
            </label>
            <div class="col-md-8">
                <textarea class="form-control" name="description" id="description" rows="5">
                    {{ old('description', $data['description'] ?? '') }}
                </textarea>
            </div>
        </div>
    </div>
</div>