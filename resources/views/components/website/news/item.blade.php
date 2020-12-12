<article class="card box-shadow news__card">
    <img class="card-img-top" src="{{ ImgHelper::get($post->image, config('maguttiCms.image.defaults')) }}" alt="{{ $post->title }}">
    <div class="card-body bg-color-3">
        <small class="text-accent">
            {{ Carbon::parse($post->date)->format('d/m/Y') }}
        </small>
        <h4 class="card-title text-primary">{{ $post->title }}</h4>
        <div class="card-text">{{ $post->getExcerpt() }}</div>
        <a href="{{ $post->getPermalink() }}" class="btn btn-sm btn-outline-color-4 mt-2">
            {{ trans('website.read_more') }} {{ icon('fas fa-caret-right') }}
        </a>
    </div>
</article>