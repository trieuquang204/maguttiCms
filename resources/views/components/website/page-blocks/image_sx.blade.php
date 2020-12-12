@props([
    'type'=>'blocks',
    'button_color'=>'btn-outline-color-4',
])
<div class="row blocks-item ">
    <div class="col-lg-6 d-flex justify-content-end blocks-image">
        <x-website.page-blocks.image :block="$block" type="blocks" />
    </div>
    <div class="col-lg-6 {{$type}}-content">
        <x-website.page-blocks.content :block="$block" :buttonColor="$button_color" />
    </div>
</div>
