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
    <x-website.partials.page-content :article="$article" class="bg-color-2"></x-website.partials.page-content>
    <x-website.page-blocks.lists :item="$article"/>
    <x-website.partials.section  class="pt-0 pb-2">
        <x-website.widgets.sharer :item="$article" class="text-left"/>
    </x-website.partials.section>
@endsection
