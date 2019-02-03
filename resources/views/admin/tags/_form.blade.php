<div class="form-group row">
    <label for="title" class="col-md-3 col-form-label">
        标题
    </label>
    <div class="col-md-8">
        <input type="text" class="form-control" name="title" id="title" value="{{ old('title', $data['title']??'') }}">
    </div>
</div>

<div class="form-group row">
    <label for="description" class="col-md-3 col-form-label">
        描述信息
    </label>
    <div class="col-md-8">
        <textarea class="form-control" id="description" name="description" rows="3">
            {{ old('description', $data['description']??'') }}
        </textarea>
    </div>
</div>

<div class="form-group row">
    <label for="page_image" class="col-md-3 col-form-label">
        图片
    </label>
    <div class="col-md-8">
        <input type="text" class="form-control" name="page_image" id="page_image" value="{{ old('page_image', $data['page_image']??'') }}">
    </div>
</div>

<div class="form-group row">
    <label for="reverse_direction" class="col-md-3 col-form-label">
        排序
    </label>
    <div class="col-md-7">
        <label class="radio-inline">
            <input type="radio" name="reverse_direction" id="reverse_direction"
                   @if (! old('reverse_direction', $data['reverse_direction']??''))
                   checked="checked"
                   @endif
                   value="0">
            升序
        </label>
        <label class="radio-inline">
            <input type="radio" name="reverse_direction"
                   @if (old('reverse_direction', $data['reverse_direction']??''))
                   checked="checked"
                   @endif
                   value="1">
            逆序
        </label>
    </div>
</div>