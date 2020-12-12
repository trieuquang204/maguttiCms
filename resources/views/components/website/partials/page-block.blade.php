@props([
    'class',
    'classCaption',
    'color',
    'buttonClass',
    'item',
])
<x-website.partials.section  class="{{$class ?? '' }}" classCaption="{{$classCaption ?? 'text-color-4'}}">
    <x-slot name="caption">{!! $item->subtitle!!}</x-slot>
    <div class=" h1 {!! $color ?? 'text-white' !!}  text-center">{!! $item->title !!}</div>
    <div class="tags-content mb-3 {!! $color ?? ' text-white' !!}">{!!  $item->description !!}</div>
    <x-website.ui.button :item="$item" class="{{ $buttonClass ?? 'btn-outline-color-4' }}"/>
</x-website.partials.section>