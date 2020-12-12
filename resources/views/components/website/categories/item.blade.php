<article class="card box-shadow category__card">
    <img class="card-img-top" src="{{ ImgHelper::get($category->image, config('maguttiCms.image.defaults')) }}" alt="{{ $category->title }}">
    <div class="card-body bg-color-3">
        <h4 class="card-title text-primary">{{ $category->title }}</h4>
        <div class="card-text">{!!   $category->description !!}</div>
        <a href="{{ $category->getPermalink() }}" class="btn btn-sm btn-outline-accent mt-2">
            {{ trans('website.product.see_all') }} {{ icon('fas fa-caret-right') }}
        </a>
    </div>
</article>