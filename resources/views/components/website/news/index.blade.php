<section class="py-2 py-md-4">
    <div class="container">
        <div class="row">
            @foreach ($posts($attributes['tag']) as $post)
                <div class="col-12 col-sm-6 col-lg-4 mb-4">
                    <x-website.news.item :post="$post"></x-website.news.item>
                </div>
            @endforeach
        </div>
        {{ $paginate() }}
    </div>
</section>