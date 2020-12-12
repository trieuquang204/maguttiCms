@extends('website.app')
@section('content')
    <x-website.ui.breadcrumbs class="bg-accent">
        <div class="text-white page-breadcrumb d-flex align-items-end">
            @if($article->parent)
                <div class="page-breadcrumb__item">{{$article->parent->title}}</div>
            @endif
            <div class="page-breadcrumb__item">{{$article->menu_title}}</div>
        </div>
    </x-website.ui.breadcrumbs>
    <section class="py-3">
      <div class="container">
            <div class="row">
		        <x-website.products.latest></x-website.products.latest>
         	</div>
      </div>
    </section>
@endsection
