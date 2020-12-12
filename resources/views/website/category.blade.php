@extends('website.app')
@section('content')
	<x-website.ui.breadcrumbs class="bg-accent">
		<div class="text-white page-breadcrumb d-flex align-items-end">
			<h1 class="page-breadcrumb__item">{{$category->title}}</h1>
		</div>
	</x-website.ui.breadcrumbs>
	<section class="py-2 py-md-4">
		<div class="container">
			<div class="row">
				@foreach ($products as $product)
					<div class="col-12 col-sm-6 col-lg-3">
						<x-website.products.item :product="$product"></x-website.products.item>
					</div>
				@endforeach
			</div>
		</div>
	</section>
@endsection
