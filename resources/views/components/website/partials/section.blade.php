@props([
'classCaption'
])
<section {{ $attributes->merge(['class' => '']) }}>
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h5  class="{{ $classCaption ?? '' }} subtitle">{{$caption ?? ''}}</h5>
                {{$slot}}
            </div>
        </div>
    </div>
</section>