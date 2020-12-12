@foreach ($products() as $product)
    <div class="col-12 col-sm-6 col-lg-4">
        <x-website.products.item :product="$product"></x-website.products.item>
    </div>
@endforeach