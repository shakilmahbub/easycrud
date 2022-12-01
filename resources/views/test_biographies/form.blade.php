
<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
    <label for="name" class="col-md-2 control-label">Name</label>
    <div class="col-md-10">
        <input class="form-control" name="name" type="text" id="name" value="{{ old('name', optional($testBiography)->name) }}" minlength="1" maxlength="255" placeholder="Enter name here...">
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('age') ? 'has-error' : '' }}">
    <label for="age" class="col-md-2 control-label">Age</label>
    <div class="col-md-10">
        <input class="form-control" name="age" type="number" id="age" value="{{ old('age', optional($testBiography)->age) }}" placeholder="Enter age here...">
        {!! $errors->first('age', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('biography') ? 'has-error' : '' }}">
    <label for="biography" class="col-md-2 control-label">Biography</label>
    <div class="col-md-10">
        <input class="form-control" name="biography" type="text" id="biography" value="{{ old('biography', optional($testBiography)->biography) }}" minlength="1" placeholder="Enter biography here...">
        {!! $errors->first('biography', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('sport') ? 'has-error' : '' }}">
    <label for="sport" class="col-md-2 control-label">Sport</label>
    <div class="col-md-10">
        <input class="form-control" name="sport" type="text" id="sport" value="{{ old('sport', optional($testBiography)->sport) }}" minlength="1" placeholder="Enter sport here...">
        {!! $errors->first('sport', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('gender') ? 'has-error' : '' }}">
    <label for="gender" class="col-md-2 control-label">Gender</label>
    <div class="col-md-10">
        <input class="form-control" name="gender" type="text" id="gender" value="{{ old('gender', optional($testBiography)->gender) }}" minlength="1" placeholder="Enter gender here...">
        {!! $errors->first('gender', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('colors') ? 'has-error' : '' }}">
    <label for="colors" class="col-md-2 control-label">Colors</label>
    <div class="col-md-10">
        <input class="form-control" name="colors" type="text" id="colors" value="{{ old('colors', optional($testBiography)->colors) }}" minlength="1" placeholder="Enter colors here...">
        {!! $errors->first('colors', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('is_retired') ? 'has-error' : '' }}">
    <label for="is_retired" class="col-md-2 control-label">Is Retired</label>
    <div class="col-md-10">
        <div class="checkbox">
            <label for="is_retired_1">
            	<input id="is_retired_1" class="" name="is_retired" type="checkbox" value="1" {{ old('is_retired', optional($testBiography)->is_retired) == '1' ? 'checked' : '' }}>
                Yes
            </label>
        </div>

        {!! $errors->first('is_retired', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('photo') ? 'has-error' : '' }}">
    <label for="photo" class="col-md-2 control-label">Photo</label>
    <div class="col-md-10">
        <div class="input-group uploaded-file-group">
            <label class="input-group-btn">
                <span class="btn btn-default">
                    Browse <input type="file" name="photo" id="photo" class="hidden">
                </span>
            </label>
            <input type="text" class="form-control uploaded-file-name" readonly>
        </div>

        @if (isset($testBiography->photo) && !empty($testBiography->photo))
            <div class="input-group input-width-input">
                <span class="input-group-addon">
                    <input type="checkbox" name="custom_delete_photo" class="custom-delete-file" value="1" {{ old('custom_delete_photo', '0') == '1' ? 'checked' : '' }}> Delete
                </span>

                <span class="input-group-addon custom-delete-file-name">
                    {{ $testBiography->photo }}
                </span>
            </div>
        @endif
        {!! $errors->first('photo', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('range') ? 'has-error' : '' }}">
    <label for="range" class="col-md-2 control-label">Range</label>
    <div class="col-md-10">
        <input class="form-control" name="range" type="text" id="range" value="{{ old('range', optional($testBiography)->range) }}" minlength="1" placeholder="Enter range here...">
        {!! $errors->first('range', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('month') ? 'has-error' : '' }}">
    <label for="month" class="col-md-2 control-label">Month</label>
    <div class="col-md-10">
        <input class="form-control" name="month" type="text" id="month" value="{{ old('month', optional($testBiography)->month) }}" minlength="1" placeholder="Enter month here...">
        {!! $errors->first('month', '<p class="help-block">:message</p>') !!}
    </div>
</div>

