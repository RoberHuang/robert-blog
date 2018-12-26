<div class="row">
    <div class="col-md-8">
        <div class="form-group row">
            <label for="article_title" class="col-md-2 control-label">
                <i class="require">*</i>标题
            </label>
            <div class="col-md-10">
                <input type="text" class="form-control" name="article_title" autofocus id="article_title" value="{{ $article_title }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="subtitle" class="col-md-2 control-label">
                <i class="require">*</i>副标题
            </label>
            <div class="col-md-10">
                <input type="text" class="form-control" name="subtitle" id="subtitle" value="{{ $subtitle }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="article_thumb" class="col-md-2 control-label">
                缩略图
            </label>
            <div class="col-md-10">
                <div class="row">
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="article_thumb" id="article_thumb" onchange="handle_image_change()" alt="Image thumbnail" value="{{ $article_thumb }}">
                    </div>
                    <script>
                        function handle_image_change() {
                            $("#page-image-preview").attr("src", function () {
                                var value = $("#article_thumb").val();
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
                        <img src="{{ page_image($article_thumb) }}" class="img img_responsive" id="page-image-preview" style="max-height:40px">
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="article_content" class="col-md-2 control-label">
                <i class="require">*</i>内容
            </label>
            <div class="col-md-10">
                <textarea class="form-control" name="article_content" rows="14" id="article_content">{{ $article_content }}</textarea>
            </div>
        </div>
        <div class="form-group row">
            <label for="article_keywords" class="col-md-2 control-label">
                关键词
            </label>
            <div class="col-md-10">
                <input type="text" class="form-control" name="article_keywords" id="article_keywords" value="{{ $article_keywords }}">
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group row">
            <label for="article_author" class="col-md-4 control-label">
                作者
            </label>
            <div class="col-md-8">
                <input type="text" class="form-control" name="article_author" autofocus id="article_author" value="{{ $article_author }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="cate_id" class="col-md-4 control-label"><i class="require">*</i>分类</label>
            <div class="col-md-8">
                <select class="form-control" name="cate_id" autofocus>
                    <option value="0">==顶级分类==</option>
                    @foreach($categories as $category)
                        <option value="{{$category->id}}" @if ($category->id == $cate_id) selected @endif >{{$category->cate_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="publish_date" class="col-md-4 control-label">
                <i class="require">*</i>发布日期
            </label>
            <div class="col-md-8">
                <input class="form-control" name="publish_date" id="publish_date" type="text" value="{{ $publish_date }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="publish_time" class="col-md-4 control-label">
                <i class="require">*</i>发布时间
            </label>
            <div class="col-md-8">
                <input class="form-control" name="publish_time" id="publish_time" type="text" value="{{ $publish_time }}">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-8 col-md-offset-4">
                <div class="checkbox">
                    <label>
                        <input {{ checked($is_draft) }} type="checkbox" name="is_draft">
                        草稿?
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="tag_ids" class="col-md-4 control-label">
                标签
            </label>
            <div class="col-md-8">
                <select name="tag_ids[]" id="tag_ids" class="form-control" multiple>
                    @foreach ($allTags as $tag)
                        <option @if (in_array($tag->id, $tag_ids)) selected @endif value="{{ $tag->id }}">
                            {{ $tag->tag }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="layout" class="col-md-4 control-label">
                <i class="require">*</i>布局
            </label>
            <div class="col-md-8">
                <input type="text" class="form-control" name="layout" id="layout" value="{{ $layout }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="article_description" class="col-md-4 control-label">
                摘要
            </label>
            <div class="col-md-8">
                <textarea class="form-control" name="article_description" id="article_description" rows="5">
                    {{ $article_description }}
                </textarea>
            </div>
        </div>
    </div>
</div>