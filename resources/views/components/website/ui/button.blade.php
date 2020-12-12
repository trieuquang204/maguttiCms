@props([
'item','label'
])
@if($item->link)
<a {{ $attributes->merge(['class' => 'btn btn-lg text-uppercase']) }} href="{{page_permalink_by_id($item->link)}}">{{$label ?? $item->btn_title}}</a>
@endif
          