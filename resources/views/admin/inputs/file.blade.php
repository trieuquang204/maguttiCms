<div class="form-file">
	<input id="file_{{$key}}" type="file" name="{{$key}}" data-selected-caption="{{trans('admin.label.file_count')}}"
			{!!  (data_get($properties,'accept')) ? 'accept="'.$properties['accept'].'"' : ''!!}>
	<label for="file_{{$key}}">{{trans('admin.label.upload_file')}}</label>
</div>
