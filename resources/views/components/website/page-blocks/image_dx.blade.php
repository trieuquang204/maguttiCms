@props([
    'type'=>'blocks',
    'button_color'=>'btn-outline-color-4',
])

<div class="row blocks-item">
    <div class="col-lg-6 {{$type}}-content justify-content-end">
        <x-website.page-blocks.content :block="$block" :buttonColor="$button_color" />
    </div>
    <div class="col-lg-6 blocks-image ">
        <x-website.page-blocks.image :block="$block"/>
    </div>
</div>