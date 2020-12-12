<li class="nav-item dropdown">
	<a class="nav-link {{$active}} dropdown-toggle" href="#" data-toggle="dropdown" title="{{$page->alt_seo_title}}">
		{{$page->nav_title}} {{icon('chevron-down ml-1')}}
	</a>
	<div class="dropdown-menu">
		@foreach ($children as $index => $child)
			@php
				$active = (!empty($current_page) && $child->id == $current_page->id) ? 'active' : '';
			@endphp
			<a class="dropdown-item {{$active}}" href="{{$child->nav_link}}" title="{{$child->alt_seo_title}}">
				{{$child->nav_title}}
			</a>
		@endforeach
	</div>
</li>
