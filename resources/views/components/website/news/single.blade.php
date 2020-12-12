<article class="news__single mr-md-2">
    <h5 class="text-muted mb-1">
        <i class="fa fa-clock mr-1"></i>{{ $news->getFormattedDate() }}
    </h5>
    <h1 class="text-primary mb-2">{{ $news->title }}</h1>
    @if($news->image)
        <img src="{{ ImgHelper::get_cached($news->image, config('maguttiCms.image.medium')) }}" alt="{{ $news->title }}" class="img-fluid mb-2">
    @endif
    {!! $news->description !!}
</article>
<x-website.widgets.tags :news="$news"/>
<x-website.widgets.sharer :item="$news"/>