<a id="delete-{{$key}}-{{$id}}"
	class="btn btn-danger media-delete"
    data-locale="{{(isset($locale)?$locale:'')}}"
	href="#"
	rel="tooltip"
	data-original-title="{{trans('admin.message.delete_item')}}"
	onclick="window.Cms.deleteImages(this)">
	{{icon('trash')}}
</a>
