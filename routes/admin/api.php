<?php


use App\maguttiCms\Middleware\AdminSuggestRole;
use App\maguttiCms\Admin\Controllers\AjaxController;
use App\maguttiCms\Api\V1\Controllers\AdminCrudController;
use App\maguttiCms\Api\V1\Controllers\AdminServicesController;
use App\maguttiCms\Admin\Controllers\SuggestAjaxController;

Route::group([], function () {
    /*
    |--------------------------------------------------------------------------
    | MEDIA LIBRARY
    |--------------------------------------------------------------------------
    */
    Route::post('uploadifiveSingle/', [AjaxController::class, 'uploadifiveSingle']);
    Route::post('uploadifiveMedia/', [AjaxController::class, 'uploadifiveMedia']);
    Route::post('cropperMedia/', [AjaxController::class, 'cropperMedia']);
    Route::get('updateHtml/media/{model?}', [AjaxController::class, 'updateModelMediaList']);
    Route::get('updateHtml/{mediaType?}/{model?}/{id?}', [AjaxController::class, 'updateMediaList']);
    Route::get('updateMediaSortList/', [AjaxController::class, 'updateMediaSortList']);
    Route::post('upload-media-tinymce/', [AjaxController::class, 'uploadMediaTinyMCE']);

    /*
    |--------------------------------------------------------------------------
    | API LIBRARY
    |--------------------------------------------------------------------------
    */

    Route::get('api/suggest', ['as' => 'api.suggest', 'uses' => [SuggestAjaxController::class,'suggest']])->middleware(AdminSuggestRole::class);
    Route::get('dashboard', [AdminServicesController::class,'dashboard']);
    Route::get('nav-bar', [AdminServicesController::class,'navbar']);

    /*
    |--------------------------------------------------------------------------
    | API SERVICES LIBRARY
    |--------------------------------------------------------------------------
    */

    Route::post('services/generator', [AdminServicesController::class,'generator']);
    /*
    |--------------------------------------------------------------------------
    | FILE MANANGER
    |--------------------------------------------------------------------------
    */
    Route::post('filemanager/upload', [AjaxController::class, 'uploadFileManager']);
    Route::get('filemanager/list/{id?}', [AjaxController::class, 'getFileManagerList']);
    Route::get('filemanager/edit/{id}', [AjaxController::class, 'editFileManager']);
    Route::post('filemanager/edit/{id}', [AjaxController::class, 'updateFileManager']);

    /*
    |--------------------------------------------------------------------------
    | CRUD LIBRARY
    |--------------------------------------------------------------------------
    */
    Route::post('create/{model}', [AdminCrudController::class,'create']);
    Route::post('update/{model}/{id}', [AdminCrudController::class,'update']);
    Route::get('update/{method}/{model?}/{id?}', [AjaxController::class, 'update']);
    Route::get('delete/{model?}/{id?}', [AjaxController::class, 'delete']);

});
