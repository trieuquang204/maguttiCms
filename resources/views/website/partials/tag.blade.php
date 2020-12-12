@unless($news->tags->isEmpty())
	<ul class="tags list-inline">
		@foreach ( $news->tags as $item )
		<li class="list-inline-item  tags-item">
			<a href="{{ $item->slug }}" target="_new" class="badge badge-pill badge-color-4 py-1 text-white">{{ $item->title }} </a>
		</li>
	@endforeach
	</ul>
@endunless