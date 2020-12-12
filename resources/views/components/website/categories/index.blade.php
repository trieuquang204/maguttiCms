<section class="py-2 py-md-4">
    <div class="container">
        <div class="row">
            @foreach ($categories() as $category)
                <div class="col-12 col-sm-6 col-lg-4 mb-2">
                    <x-website.categories.item :category="$category"></x-website.categories.item>
                </div>
            @endforeach
        </div>
    </div>
</section>