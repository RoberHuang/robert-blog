<div class="form-group row">
    <label for="title" class="col-md-3 control-label">
        标题
    </label>
    <div class="col-md-8">
        <input type="text" class="form-control" name="title" id="title" value="{{ old('title', $data['title'] ?? '') }}">
    </div>
</div>

<div class="form-group row">
    <label for="type" class="col-md-3 control-label">
        类型
    </label>
    <div class="col-md-8">
        <div class="radio-inline">
            <input type="radio" name="type" id="type" value="input" @if (old('type', $data['type'] ?? 'input') == 'input')checked="checked"@endif onclick="showTr()"> input　
        </div>
        <div class="radio-inline">
            <input type="radio" name="type" id="type" value="textarea" @if (old('type', $data['type'] ?? 'input') == 'textarea')checked="checked"@endif onclick="showTr()"> textarea　
        </div>
        <div class="radio-inline">
            <input type="radio" name="type" id="type" value="radio" @if (old('type', $data['type'] ?? 'input') == 'radio')checked="checked"@endif onclick="showTr()"> radio
        </div>
    </div>
</div>

<div class="form-group row value">
    <label for="value" class="col-md-3 control-label">
        类型值
    </label>
    <div class="col-md-8">
        <input type="text" class="form-control" name="value" id="value" value="{{ old('value', $data['value'] ?? '') }}">
        <p><i class="require">*</i>类型值只有在radio的情况下才需要配置，格式： 1|开启,0|关闭</p>
    </div>

</div>

<div class="form-group row">
    <label for="order" class="col-md-3 control-label">
        <i class="require">*</i>排序
    </label>
    <div class="col-md-8">
        <input type="text" class="form-control" name="order" id="order" value="{{ old('order', $data['order'] ?? 0) }}" required>
    </div>
</div>

<div class="form-group row">
    <label for="value" class="col-md-3 control-label">
        说明
    </label>
    <div class="col-md-8">
        <textarea class="form-control" id="remark" name="remark" rows="3">
            {{ old('remark', $data['remark'] ?? '') }}
        </textarea>
    </div>
</div>