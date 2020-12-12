<section {{ $attributes->merge(['class' => 'py-3']) }}>
    <div class="container">
        <div class="row">
        @if($article->image)
            <div class="col-12 col-md-6 order-md-2 mb-3 mb-md-0">
                <img src="{{ ImgHelper::get_cached($article->image, config('maguttiCms.image.medium')) }}"
                     alt="{{ $article->title }}" class="img-fluid">
            </div>
        @endif
        <div class="{{!$article->image? "col-12":"col-12  col-md-6 order-md-1 "}}">
            <x-website.partials.page-title>
                    {{ $article->title }}
                    @if($article->subtitle)
                        <x-slot name="subtitle">{{ $article->subtitle }}</x-slot>
                    @endif
            </x-website.partials.page-title>
            {!! HtmlHelper::content_part($article->description,1) !!}
            @foreach(HtmlHelper::content_part_looper($article->description) as $part)
                {!! $part !!}
            @endforeach
            </div>
        </div>
    </div>
</section>
