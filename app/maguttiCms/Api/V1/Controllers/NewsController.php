<?php


namespace App\maguttiCms\Api\V1\Controllers;


use App\News;
use App\Http\Resources\NewsResource;
use App\maguttiCms\Tools\JsonApiResponseTrait;

class NewsController extends BaseApiController
{
    use JsonApiResponseTrait;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    function index()
    {
        return News::paginate(10);
        return NewsResource::collection(News::paginate(10));
    }

    function show($id)
    {
        return new NewsResource(News::find($id));
    }
}