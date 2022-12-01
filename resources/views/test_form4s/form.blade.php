
<div class="form-group {{ $errors->has('colors') ? 'has-error' : '' }}">
    <label for="colors" class="col-md-2 control-label">Colors</label>
    <div class="col-md-10">
        <select class="form-control" id="colors" name="colors">
        	    <option value="" style="display: none;" {{ old('colors', optional($testForm4)->colors ?: '') == '' ? 'selected' : '' }} disabled selected>Select colors</option>
        	@foreach (['blue' => 'Blue'] as $key => $text)
			    <option value="{{ $key }}" {{ old('colors', optional($testForm4)->colors) == $key ? 'selected' : '' }}>
			    	{{ $text }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('colors', '<p class="help-block">:message</p>') !!}
    </div>
</div>

