@props([
    'class'
])
<x-website.partials.section  class="{{$class}}" classCaption="text-accent">
    <x-slot name="caption">{{$item->subtitle}}</x-slot>
    <div class=" h1 text-primary">{{$item->title}}</div>
    <div class="px-lg-15 mb-3 text-justify">{!!  $item->description !!}</div>
    <x-website.ui.button  :item="$item" class="btn-outline-primary" />
</x-website.partials.section>

