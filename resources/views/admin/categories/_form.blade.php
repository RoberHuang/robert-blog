<div class="form-group row">
    <label for="title" class="col-md-3 control-label">
        标题
    </label>
    <div class="col-md-8">
        <input type="text" class="form-control" name="title" id="title" value="{{ old('title', $data['title']??'') }}">
    </div>
</div>

<div class="form-group row">
    <label for="description" class="col-md-3 control-label">
        描述
    </label>
    <div class="col-md-8">
        <textarea class="form-control" id="description" name="description" rows="3">
            {{ old('description', $data['description']??'') }}
        </textarea>
    </div>
</div>

<div class="form-group row">
    <label for="order" class="col-md-3 control-label">
        <i class="require">*</i>排序
    </label>
    <div class="col-md-8">
        <input type="text" class="form-control" name="order" id="page_image" value="{{ old('order', $data['order']??0) }}" required>
    </div>
</div>