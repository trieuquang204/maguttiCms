<?php

return [
    'repository'     => env('ASSET_PUBLIC_PATH','').'media/',
    'img_repository' => env('ASSET_PUBLIC_PATH','').'media/images/',
    'img_save'       => env('ASSET_PUBLIC_PATH','').'media/images/cache/',
    'doc_repository' => env('ASSET_PUBLIC_PATH','').'media/docs/',

    'media_img_repository' => env('ASSET_PUBLIC_PATH','').'media/images/',
    'media_doc_repository' => env('ASSET_PUBLIC_PATH','').'media/docs/',

	'cms'            => 'cms/',
	'cms_assets'     => 'cms/',
	'cms_js'         => 'cms/js/',
	'cms_css'        => 'cms/css/',

    'assets'     	 => env('ASSET_PUBLIC_PATH',''),
    'common_js'      => env('ASSET_PUBLIC_PATH','').'js/',
    'js_vendor'      => env('ASSET_PUBLIC_PATH','').'js/vendor/',
    'plugins'        => env('ASSET_PUBLIC_PATH','').'plugins/',
	'common_css'     => env('ASSET_PUBLIC_PATH','').'css/',
	'css_vendor'     => env('ASSET_PUBLIC_PATH','').'css/vendor/',

	'user_upload'    => 'upload/',

    'export_data'     => 'export/',
    'shared'         => 'shared_data/',


];
