@include('admin.helper.media_category')
<input id="itemId" name="itemId" type="hidden" value="{!! $article->id!!}">
<div class="form-file p-2 bg-light">
	<input id="cropper-upload-media" type="file" data-selected-caption="{{trans('admin.label.file_count')}}" data-empty-caption="{{trans('admin.label.upload_file')}}" {!!(array_key_exists('accept', $pageConfig['mediaCropper']))? 'accept="' .$pageConfig['mediaCropper']['accept'].'"': '' !!}>
	<label for="cropper-upload-media">{{trans('admin.label.upload_file')}}</label>
</div>
<div id="cropper-toolbar-media" class="cropper-toolbar">
	<button type="button" class="btn btn-default" id="cropper-zoom-in-media">{{icon('plus')}}<span class="d-none d-lg-inline-block">{{ trans('admin.cropper.zoom_in')}}</span> </button>
	<button type="button" class="btn btn-default" id="cropper-zoom-out-media">{{icon('minus')}}<span class="d-none d-lg-inline-block">{{ trans('admin.cropper.zoom_out') }}</span> </button>
	<button type="button" class="btn btn-info" id="cropper-preview-media" data-toggle="modal" data-target="#cropper-preview-modal-media">{{icon('eye')}}<span class="d-none d-lg-inline-block">{{trans('admin.cropper.preview')}}</span></button>
	<button type="button" class="btn btn-success" id="cropper-save-media">{{icon('save')}}<span class="d-none d-lg-inline-block">{{trans('admin.cropper.save')}}</span> </button>
</div>
<div class="cropper-wrapper">
	<img id="cropper-container-media" class="cropper-container">
</div>
<input id="cropper-data-media" name="media" type="hidden" autocomplete="off">
<input id="cropper-filename-media" name="media-filename" type="hidden" autocomplete="off">

<div class="modal fade" id="cropper-preview-modal-media" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Preview</h4>

				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<img id="cropper-preview-image-media" src="" class="img-fluid cropper-preview">
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
			dragMode: 'move'
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
		Cms.initCropper('media', cropper_options, file_options);
	});
	</script>
@endsection
