@include('admin.helper.media_category')
<input id="itemId" name="itemId" type="hidden" value="{!! $article->id!!}">
<div class="alert alert-info">
	<input id="file_upload_media" name="file_upload" type="file" multiple="true" class="btn btn-primary file_upload_media">
	<div id="queue_media" class="queue">{!!trans('admin.message.media_drag') !!}</div>
</div>
<a href="javascript:$('#file_upload_media').uploadifive('upload')" class="btn btn-primary hidden">
	{{icon('download')}} {!! trans('admin.label.upload_file')!!}
</a>
