<a href="{!! ma_get_file_from_storage($media->getValue(), $media->getDisk() , $media->getFolder()); !!}" class="red" target="_new">
    <img src="{!! ImgHelper::init($media->getFolder(),$media->getDisk())->get_cached($media->getValue(), config('maguttiCms.image.admin')) !!}" class="img-thumb">
</a>