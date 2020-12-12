<?php

namespace App\maguttiCms\Domain\Category;

use App\Category;
use App\maguttiCms\Domain\Website\WebsiteViewModel;

class CategoryViewModel extends WebsiteViewModel
{

    function show($slug)
    {
        $category = Category::findBySlug($slug, app()->getLocale());
        if ($category) {
            $article = $this->getPage('progetti');
            $this->setSeo($category);
            $locale_article = $category;
            $products = $category->products()->published()->orderBy('sort')->get();
            $template = 'category';
            return view('website.'.$template, compact('article', 'category', 'products', 'locale_article'));
        }
        return $this->handleMissingPage();

    }

    function index()
    {
        $article = $this->getCurrentPage();

        $this->setSeo($article);
        $template = ($article->template_id) ? $article->template->value : 'categories';
        return view('website.'.$template, ['article' => $article]);

    }

    function handle($slug)
    {
        return ($slug == '') ? $this->index() : $this->show($slug);
    }
}