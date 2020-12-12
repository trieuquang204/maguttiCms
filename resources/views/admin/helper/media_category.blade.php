@if ($pageConfig->get('showMediaCategory') == 1 && $article->id!='')
	@inject('domain','App\Domain')
	<div class="form-group">
		<h5>{!!trans('admin.message.media_doc_type') !!}</h5>
		<select id="myImgType" name="myImgType" class="form-control mid-input full-xs">
			<option value=''>{!! trans('admin.label.please_select')!!}</option>
			@foreach ( $domain->byDomain('imagetype')->get() as $index => $item )
				<option value="{!! $item->id !!}">{!! $item->title !!}</option>
			@endforeach
		</select>
	</div>
	<hr />
@endif
