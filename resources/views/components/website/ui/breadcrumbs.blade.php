<section {{ $attributes->merge(['class' => 'p-0']) }}>
    <div class="container">
        <div class="row">
            <div class="col-12">
                {{$slot}}
            </div>
        </div>
    </div>
</section>