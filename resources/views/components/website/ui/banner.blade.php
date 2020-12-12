@props([
    'class',
    'classCaption',
    'classTitle',
    'classContent',
    'item',
])
<x-website.section class="{{$class}}" classCaption="{{$classCaption ?? 'text-primary'}}">
    <x-slot name="caption">{!! $item->subtitle!!}</x-slot>
    <h1 class="{{$classTitle ?? 'text-white'}} banner-title">{!! $item->title !!}</h1>
        @if($item->description)
        <div class="banner-content {{$classContent ?? 'text-white'}}">{!!  $item->description !!}</div>
    @endif
</x-website.section>