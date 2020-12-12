@if ($pageConfig->get('showMediaImages') == 1)
	<hr/>
	<div id="imagesList">
		<h3>{!!trans('admin.message.media_image_gallery') !!}</h3>
		<ul class="thumbnails list-unstyled" id="simpleGallery">
			@include('admin.helper.images_list_gallery')
		</ul>
	</div>
@endif
