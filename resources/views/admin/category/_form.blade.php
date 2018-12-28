<div class="form-group row">
    <label for="cate_title" class="col-md-3 control-label">
        标题
    </label>
    <div class="col-md-8">
        <input type="text" class="form-control" name="cate_title" id="cate_title" value="{{ $cate_title }}">
    </div>
</div>

<div class="form-group row">
    <label for="cate_keywords" class="col-md-3 control-label">
        关键词
    </label>
    <div class="col-md-8">
        <input type="text" class="form-control" name="cate_keywords" id="cate_keywords" value="{{ $cate_keywords }}">
    </div>
</div>

<div class="form-group row">
    <label for="cate_description" class="col-md-3 control-label">
        描述
    </label>
    <div class="col-md-8">
        <textarea class="form-control" id="cate_description" name="cate_description" rows="3">
            {{ $cate_description }}
        </textarea>
    </div>
</div>

<div class="form-group row">
    <label for="cate_order" class="col-md-3 control-label">
        <i class="require">*</i>排序
    </label>
    <div class="col-md-8">
        <input type="text" class="form-control" name="cate_order" id="page_image" value="{{ $cate_order }}" required>
    </div>
</div>