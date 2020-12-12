@extends('website.app')
@section('content')
	<x-website.partials.page-header  :title="$article->title"/>
	<main class="my-5">
        <div class="container">
 		{!! $article->description !!}
		</div>
	</main>
	
@endsection
