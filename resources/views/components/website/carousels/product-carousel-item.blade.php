
<div {{ $attributes->merge(['class' => 'item']) }}>
   <a href="{{$item ->getPermalink()}}">
      <img src="{{ ImgHelper::get_cached($item->image, ['w' => 300, 'h' => 200, 'q' => 70],'products') }}"
           alt="" class="img-fluid">
      <div class="caption text-center mt-2">
         <h6 class="text-primary caption"><strong>{{$item->title }}</strong></h6>
      </div>
   </a>
</div>

