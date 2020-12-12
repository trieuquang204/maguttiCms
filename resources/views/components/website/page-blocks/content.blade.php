@if($block->subtitle)
    <h5 class="blocks-subtitle text-accent">{!! $block->subtitle !!}</h5>
@endif
<h2 class="blocks-title">{{ $block->title }}</h2>
{!! $block->description !!}
@if($block->nav_link)
<a class="mt-2 mb-2 mt-md-3 btn btn-lg {{ $buttonColor ?? 'btn-outline-color-4'}}"
   href="{{$block->nav_link}}">{{trans('website.see_all')}}
</a>
@endif