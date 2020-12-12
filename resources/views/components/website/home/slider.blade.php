<header id="carousel" {{ $attributes->merge(['class' => 'slider owl-carousel ']) }}>
    @foreach ($slides() as $index => $slide)
        <div class="item">
            <img src="{{ ImgHelper::get_cached($slide->image, ['w' => 1920, 'h' => 600, 'c' => 'cover', 'q' => 70]) }}" alt="" class="img-fluid">

            <div class="slider-text">
                <div class="container">
                    <h2 class="text-primary">{{ $slide->title }}</h2>
                    <div class="lead">{{ $slide->description }}</div>
                </div>
            </div>
        </div>
    @endforeach
</header>

@push('scripts')
<script type="text/javascript">
    $('#carousel').owlCarousel({
        items: 1,
        loop: true,
        dots: true,
        nav: true,
        navText: ['<i class="fa fa-arrow-left"></i>', '<i class="fa fa-arrow-right"></i>'],
    });
</script>
@endpush

