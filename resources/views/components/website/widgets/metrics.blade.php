<div id="counter" class="mt-3 counter d-flex flex-wrap justify-content-between">
    @foreach($getItems() as $counter)
        <div class="counter-item col-12 col-sm-3">
            <div class="counter-number running" id="counter_{{$counter->id}}"
                 data-count="{{$counter->value}}">0</div>
            <div class="counter-title h5">{{$counter->title}}</div>
        </div>
    @endforeach
</div>


@section('footerjs')
    <script type="text/javascript">
        var a = 0;
        $(window).scroll(function () {
            var oTop = $('#counter').offset().top - window.innerHeight;
            if (a == 0 && $(window).scrollTop() > oTop) {
                $('.counter-number').each(function () {
                   let  $this = $(this),
                        countTo = $this.attr('data-count');
                    $(this).addClass('running')
                    $({
                        countNum: $this.text()
                    }).animate({
                            countNum: countTo
                        },
                        {
                            duration: 2000,
                            easing: 'swing',
                            step: function () {
                                $this.text(Math.floor(this.countNum));
                            },
                            complete: function () {
                                $this.text(this.countNum);
                                $this.removeClass('running')
                            }

                        });
                });
                a = 1;
            }
            else if($(window).scrollTop() < oTop-100) {
                $('.counter-number').each(function () {
                    let  $this = $(this)
                    $this.text(0);
                    a=0;
                });
            }
        });
    </script>
@endsection


