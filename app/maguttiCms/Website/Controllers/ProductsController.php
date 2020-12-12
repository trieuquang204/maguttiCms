<?php

namespace App\maguttiCms\Website\Controllers;


use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Article;
use App\maguttiCms\Domain\Category\CategoryViewModel;
use App\maguttiCms\Domain\Product\ProductViewModel;



/**
 * Class ProductsController
 * @package App\maguttiCms\Website\Controllers
 */
class ProductsController extends Controller
{

    public function category($category_slug = '')
    {
      $slug= $this->resolvePageSlug();
      return (new CategoryViewModel($slug))->handle($category_slug);
    }


    public function products($category_slug, $product_slug)
    {
      $slug= $this->resolvePageSlug();
      return (new ProductViewModel($slug))->handle($product_slug);
    }
    function resolvePageSlug(){
        $segments = request()->segments();;
        return end($segments);
    }
}
