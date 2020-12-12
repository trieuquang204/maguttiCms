<?php


/*
|--------------------------------------------------------------------------
| FRONT END API
|--------------------------------------------------------------------------
*/

use App\maguttiCms\Website\Controllers\APIController;
use App\maguttiCms\Website\Controllers\Auth\ForgotPasswordController;
use App\maguttiCms\Website\Controllers\Auth\LoginController;
use App\maguttiCms\Website\Controllers\Auth\RegisterController;
use App\maguttiCms\Website\Controllers\Auth\ResetPasswordController;
use App\maguttiCms\Website\Controllers\PagesController;
use App\maguttiCms\Website\Controllers\ProductsController;
use App\maguttiCms\Website\Controllers\ReservedAreaController;
use App\maguttiCms\Website\Controllers\StoreAPIController;
use App\maguttiCms\Website\Controllers\WebsiteFormController;

Route::group([], function () {
    Route::post('api/update-ghost', [APIController::class, 'updateGhost']);

    // store section
    Route::post('api/store/cart-item-add', [StoreAPIController::class, 'storeCartItemAdd']);
    Route::post('api/store/cart-item-remove', [StoreAPIController::class, 'storeCartitemRemove']);
    Route::post('api/store/cart-item-update', [StoreAPIController::class, 'updateItemQuantity']);
    Route::get('api/store/order-calc', [StoreAPIController::class, 'storeOrderCalc']);
    Route::get('api/store/order-discount', [StoreAPIController::class, 'storeOrderDiscount']);
});

/*
|--------------------------------------------------------------------------
| FRONT END
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'usercart']], function () {
    // Api
    Route::post('/api/newsletter', [APIController::class, 'subscribeNewsletter']);

    // Authentication routes...
    Route::get('users/login', [LoginController::class, 'showLoginForm'])->name('users/login');
    Route::post('users/login', [LoginController::class, 'login']);
    Route::get('users/logout', [LoginController::class, 'logout']);

    // Reserved area user routes
    Route::group(['middleware' => ['auth']], function () {
        Route::get('users/dashboard', [ReservedAreaController::class, 'dashboard']);
        Route::get('users/address-new', [ReservedAreaController::class, 'addressNew']);
        Route::post('users/address-new', [ReservedAreaController::class, 'addressCreate']);
        Route::get('users/profile', [ReservedAreaController::class, 'profile']);
    });

    // Registration routes...
    Route::get('/register', [RegisterController::class, 'showRegistrationForm']);
    Route::post('/register', [RegisterController::class, 'register']);

    // Password Reset Routes...
    Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm']);
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail']);
    Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm']);
    Route::post('password/reset', [ResetPasswordController::class, 'reset']);

    // Pages routes...
    Route::get('/', [PagesController::class, 'home']);
    Route::get('/news/', [PagesController::class, 'news']);
    Route::get('/news/tags/{tags}', [PagesController::class, 'newsByTags']);
    Route::get('/news/{slug}', [PagesController::class, 'news']);
    Route::get('/faq/', [PagesController::class, 'faq']);
    Route::get('/faq/{slug}', [PagesController::class, 'faq']);

    Route::get(LaravelLocalization::transRoute("routes.category"), [ProductsController::class, 'category']);
    Route::get(LaravelLocalization::transRoute("routes.products"), [ProductsController::class, 'products']);
    Route::get(LaravelLocalization::transRoute("routes.contacts"), [PagesController::class, 'contacts']);

    Route::post('/contacts/', [WebsiteFormController::class, 'getContactUsForm']);

    // store page
    Route::name('store')->group(base_path('routes/frontend/store.php'));

    //Route::name('seolanding')->group(base_path('routes/frontend/seolanding.php'));

    Route::get('/{parent}/{child}', [PagesController::class, 'pages']);
    Route::get('/{parent?}/', [PagesController::class, 'pages']);
});
