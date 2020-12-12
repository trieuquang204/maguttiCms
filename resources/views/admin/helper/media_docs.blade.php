@if ($pageConfig->get('showMediaDoc') == 1)
	<hr/>
	<div id="docsList">
		<h3>{!!trans('admin.message.media_doc_gallery') !!}</h3>
		<div id="docsListBody">
			<ul class="thumbnails" id="simpleDocGallery">
				@include('admin.helper.docs_list')
			</ul>
		</div>
	</div>
@endif
