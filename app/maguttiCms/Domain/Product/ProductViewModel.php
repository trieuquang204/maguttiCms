<?php

namespace App\maguttiCms\Domain\Product;

use App\maguttiCms\Domain\Website\WebsiteViewModel;
use App\Product;


class ProductViewModel extends WebsiteViewModel
{


    function show($slug)
    {
        $product = Product::findBySlug($slug, app()->getLocale());
        $article = $this->getCurrentPage();
        // singolo prodotto
        if ($product) {
            $category = $product->category;
            $locale_article = $product;
            $this->setSeo($product);
            return view('website.product', compact('article', 'product', 'category', 'locale_article'));
        }
        return $this->handleMissingPage();
    }

    

    function handle($slug)
    {
        return ($slug == '') ? $this->index() : $this->show($slug);
    }
}