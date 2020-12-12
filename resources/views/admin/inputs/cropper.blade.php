<div class="form-file">
	<input id="cropper-upload-{{$key}}" type="file" data-selected-caption="{{trans('admin.label.file_count')}}" {!!(isset($properties['accept']))? 'accept="' .$properties['accept'].'"': '' !!}>
	<label for="cropper-upload-{{$key}}">{{trans('admin.label.upload_file')}}</label>
</div>
<div id="cropper-toolbar-{{$key}}" class="cropper-toolbar">
	<button type="button" class="btn btn-default" id="cropper-zoom-in-{{$key}}">{{icon('plus')}}{{ trans('admin.cropper.zoom_in') }}</button>
	<button type="button" class="btn btn-default" id="cropper-zoom-out-{{$key}}">{{icon('minus')}}{{ trans('admin.cropper.zoom_out') }}</button>
	<button type="button" class="btn btn-info" id="cropper-preview-{{$key}}" data-toggle="modal" data-target="#cropper-preview-modal-{{$key}}">{{icon('eye')}}{{ trans('admin.cropper.preview') }}</button>
</div>
<div class="cropper-wrapper">
	<img id="cropper-container-{{$key}}" class="cropper-container">
</div>
<input id="cropper-data-{{$key}}" name="{{$key}}" type="hidden" autocomplete="off">
<input id="cropper-filename-{{$key}}" name="{{$key}}-filename" type="hidden" autocomplete="off">

<div class="modal fade" id="cropper-preview-modal-{{$key}}" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Preview</h4>

				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<img id="cropper-preview-image-{{$key}}" src="" class="img-fluid cropper-preview">
			</div>
		</div>
	</div>
</div>

@section('footerjs')
	@parent
	<script type="text/javascript">
		$(function() {
			var cropper_options = {
				@if ($cropperConfig->has('ratio'))
					aspectRatio: {{$cropperConfig->get('ratio')}},
				@endif
				viewMode: 0,
				dragMode: 'move',
			};
			var file_options = {
				@if ($cropperConfig->has('fill'))
					fillColor: '{{$cropperConfig->get('fill')}}',
				@endif
				@if ($cropperConfig->has('format'))
					format: '{{$cropperConfig->get('format')}}',
				@endif
				@if ($cropperConfig->has('format'))
					extension: '{{$cropperConfig->get('extension')}}',
				@endif
				@if ($cropperConfig->has('width'))
					width: {{$cropperConfig->get('width')}},
				@endif
				@if ($cropperConfig->has('height'))
					height: {{$cropperConfig->get('height')}},
				@endif
				imageSmoothingEnabled: true,
				imageSmoothingQuality: 'high',
			};
			Cms.initCropper('{{$key}}', cropper_options, file_options);
		});
	</script>
@endsection
