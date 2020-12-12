<?php


namespace App\maguttiCms\Api\V1\Controllers;


use App\Article;
use App\Http\Resources\ArticleResource;
use App\maguttiCms\Tools\JsonApiResponseTrait;

class ArticlesController extends BaseApiController
{
    use JsonApiResponseTrait;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    function index()
    {
        return ArticleResource::collection(Article::paginate(10));
    }

    function show($id)
    {
        $item = Article::find($id);
        return new ArticleResource($item);
    }
}