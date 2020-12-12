@extends('website.app')
@section('content')
    <x-website.ui.breadcrumbs class="bg-dark">
        <div class="text-white page-breadcrumb d-flex align-items-end">
            @if($article->parent)
                <div class="page-breadcrumb__item">{{$article->parent->title}}</div>
            @endif
            <div class="page-breadcrumb__item">{{$article->menu_title}}</div>
        </div>
    </x-website.ui.breadcrumbs>
    <x-website.partials.section :class="'bg-accent py-5'" classCaption="text-primary">
        <x-slot name="caption">{{$article->subtitle}}</x-slot>
        <h1 class="h1 text-white">{!! $article->title !!}</h1>
    </x-website.partials.section>
    <x-website.partials.section class="py-1">
        <x-website.ui.accordion :items="$faqs"/>
    </x-website.partials.section>
@endsection
