<article class="card box-shadow products__card mb-3">
    <img class="card-img-top" src="{{ ImgHelper::get($product->image, config('maguttiCms.image.defaults'),'products') }}" alt="{{ $product->title }}">
    <div class="card-body bg-color-3">
        <h4 class="card-title text-primary"><span class="text-uppercase">{{ $product->title }}</span> <span class="card-code text-muted"> - {{ trans('store.product.code') }}: {{ $product->code }}</span> </h4>
        <div class="card-price">{{ StoreHelper::formatProductPrice($product) }}</div>
        <a href="{{ $product->getPermalink() }}" class="btn btn-sm btn-outline-accent mt-2">
            {{ trans('website.see') }} {{ icon('fas fa-caret-right') }}
        </a>
    </div>
</article>
