<div id="seo-links" class="container">
	<ul>
		@foreach (SeoLandingHelper::getLinks('product-by-city') as $_slug => $_title)
			<li>
				<a href="{{url_locale($_slug)}}" title="{{$_title}}">{{$_title}}</a>
			</li>
		@endforeach
	</ul>
</div>
