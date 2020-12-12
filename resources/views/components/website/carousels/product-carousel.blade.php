<section {{ $attributes->merge(['class' => '']) }}>
   <div class="container">
      <div class="row">
         <div class="col-sm-12 text-center mb-2">
            <h2 class="text-color-4" >{!! $item->title !!}</h2>
            <h4 class="text-primary">{!! $item->subtitle !!}</h4>
         </div>
      </div><!-- /row -->
      <div class="row py-2">
         <div class="product-carousel owl-carousel owl-theme">
            @foreach (  $carousel_items()  as  $index => $carousel_item )
               <x-website.carousels.product-carousel-item :item="$carousel_item" class="item"></x-website.carousels.product-carousel-item>
            @endforeach
         </div>
         <!--Grid column-->
      </div>
      <div class="row text-center mt-2 mt-sm-3">
         <x-website.ui.button :item="$item" :label="trans('website.see_all')" class="{{$buttonClass ?? 'btn-primary m-auto' }}"/>
         <!--Grid column-->
      </div>
      <!--Grid row-->
   </div>
</section>
@once
   @push('scripts')
      <script type="text/javascript">
         var sectorOwl = $('.product-carousel');
         sectorOwl.owlCarousel({
            loop: true,
            margin: 25,
            nav: false,
            dots: true,
            navText: ['<i class="fa fa-angle-left text-color-accent"></i>', '<i class="fa fa-angle-right text-color-accent"></i>'],
            responsive: {
               0: {
                  items: 1
               },
               800: {
                  items: 2
               },
               1000: {
                  items: 3
               }
            },
         });
      </script>
   @endpush
@endonce


@once
   @push('scripts')
      <script type="text/javascript">
         var carouselOwl = $('.carousel');
         sectorOwl.owlCarousel({
            loop: true,
            margin: 25,
            dots: true,
            responsive: {
               800: {
                  items: 2
               },
               1000: {
                  items: 3
               }
            },
         });
      </script>
   @endpush
@endonce
