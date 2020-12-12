@props(['id'])
<div @if($id!='') id="{{$id}}" @endif {{ $attributes->merge(['class' =>'card'])}}>
    <h3>{!! $title !!}</h3>
    <hr/>
    {{ $slot }}
</div>