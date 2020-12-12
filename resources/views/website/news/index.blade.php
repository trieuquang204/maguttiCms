@extends('website.app')
@section('content')
	<x-website.ui.breadcrumbs class="bg-accent">
		<div class="text-white page-breadcrumb d-flex align-items-end">
			<div class="page-breadcrumb__item">{{$article->title}}</div>
			@if($tag)
				<div class="page-breadcrumb__item">{{$tag}}</div>
			@endif
		</div>
	</x-website.ui.breadcrumbs>
	<x-website.news.index :tag="$tag"></x-website.news.index>
@endsection
