
<div class="accordion text-left">
    @foreach($items as $item)
        <div class="accordion-item d-md-flex" style="border-bottom:3px solid red">
            <div class="col-12 col-md-6 h3 accordion-item-title collapsed " data-toggle="collapse" href="#item_{{$item->id}}">
                {{$item->title}}
            </div>
            <div class="collapse col-12 col-md-6 accordion-item-description" id="item_{{$item->id}}">
                {!! $item->description!!}
            </div>
        </div>
    @endforeach
</div>