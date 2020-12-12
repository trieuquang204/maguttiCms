@extends('website.app')
@section('content')
	<x-website.ui.breadcrumbs class="bg-accent">
		<div class="text-white page-breadcrumb d-flex align-items-end">
			<div class="page-breadcrumb__item"><a href="{{$product->category->getPermalink()}}">{{$product->category->title}}</a></div>
			<div class="page-breadcrumb__item">{{$product->title}}</div>
		</div>
	</x-website.ui.breadcrumbs>
	<section class="product-page">
		<div class="container">
			<div class="row no-gutters">
				<div class="col-12 col-sm-6 order-md-1 my-2 my-md-0 product-page-image">
					<img class="img-fluid" src="{{ ImgHelper::init('products')->get_cached($product->image, config('maguttiCms.image.large')) }}" alt="{{ $product->title }}">
				</div>
				<div class="col-12 col-sm-6 order-md-2">
					<div class="product-page-card">
						<h1 class="text-primary product-page-title">{{ $product->title }}</h1>
						<h5 class="text-color-4 product-page-code">{{ trans('store.product.code') }}: {{ $product->code }}</h5>
						<div class="product-page-description">{!! $product->description !!}</div>
						@if (StoreHelper::isStoreEnabled())
							<h4 class="product-page-price">{{ StoreHelper::formatProductPrice($product) }}</h4>
							<cart-add-item
									ref="v100"
									:product="{{$product}}" :min=1 :step="1"  :max="100" :value=1>
								<template #label>{{ trans('store.items.add') }}</template>
							</cart-add-item>
						@endif
					</div>

				</div>
			</div>
		</div>
	</section>

@endsection
