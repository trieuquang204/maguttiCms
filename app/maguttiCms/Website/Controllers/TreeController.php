<?php

namespace App\maguttiCms\Website\Controllers;

use App\Article;
use App\Http\Controllers\Controller;
use App\maguttiCms\Admin\Decorators\TreeDecorator;


class TreeController extends Controller
{

    function index()
    {
        $articles = Article::orderBy('sort')->get();
        return view('website/tree/tree', compact('articles'));
    }

}
