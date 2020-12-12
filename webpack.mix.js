const mix = require('laravel-mix');
require('laravel-mix-merge-manifest');
/*
 |--------------------------------------------------------------------------
 | Mix Asset Fo development Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
*/
if (mix.config.production || mix.config.development) {
	mix.sass('resources/sass/website/vendor.scss', 'public/website/css')
	mix.js('resources/js/website/vendor.js', 'public/website/js')
	mix.sass('resources/sass/admin/vendor.scss', 'public/cms/css/')
	mix.js('resources/js/admin/cmsvendor.js', 'public/cms/js/cmsvendor.js')
	mix.version();
} else {
	//mix.config.processCssUrls = false;
}

/*
 |--------------------------------------------------------------------------
 | Website
 |--------------------------------------------------------------------------
*/

mix.sass('resources/sass/website/app.scss', 'public/website/css')
mix.js('resources/js/website/app.js', 'public/website/js')
//mix.js('resources/js/website/store.js', 'public/website/js');
mix.js('resources/js/website/cart.js', 'public/website/js');

/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/

mix.sass('resources/sass/admin/app.scss', 'public/cms/css/')
mix.js('resources/js/admin/cms.js', 'public/cms/js/cms.js')
mix.js('resources/js/admin/header.js', 'public/cms/js/header.js')
mix.js('resources/js/admin/lara-file-manager.js', 'public/cms/js')
mix.js('resources/js/admin/appcms.js', 'public/cms/js/');

mix.mergeManifest();