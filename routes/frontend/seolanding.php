<?php
// Seo landing pages
foreach (config('maguttiCms.website.seolanding') as $_link) {
    Route::get($_link['route'],'\App\maguttiCms\Website\Controllers\SeoLandingController@'.$_link['method'])->where($_link['constraints']);
}