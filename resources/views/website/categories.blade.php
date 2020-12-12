@extends('website.app')
@section('content')
   <x-website.ui.breadcrumbs class="bg-accent">
        <div class="text-white page-breadcrumb d-flex align-items-end">
            @if($article->parent)
                <div class="page-breadcrumb__item">{{$article->parent->title}}</div>
            @endif
            <div class="page-breadcrumb__item">{{$article->title}}</div>
        </div>
    </x-website.ui.breadcrumbs>
    <x-website.categories.index></x-website.categories.index>
@endsection
