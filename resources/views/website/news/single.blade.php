@extends('website.app')
@section('content')
    <x-website.ui.breadcrumbs class="bg-accent">
        <div class="text-white page-breadcrumb d-flex align-items-end">
            <div class="page-breadcrumb__item"><a href="{{$article->getPermalink()}}">{{$article->title}}</a></div>
        </div>
    </x-website.ui.breadcrumbs>
    <section class="py-2 py-md-4">
		<div class="container">
            <div class="row">
                <div class="col-12 col-md-9">
                    <x-website.news.single :news="$news"/>

                </div>
                <div class="col-12 col-md-3 d-none d-md-block">
                    <x-website.news.sidebar/>
                </div>
            </div>
		</div>
 	</section>
@endsection
