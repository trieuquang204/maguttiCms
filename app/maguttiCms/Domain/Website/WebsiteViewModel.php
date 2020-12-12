<?php

namespace App\maguttiCms\Domain\Website;


use App\Article;
use \App\maguttiCms\SeoTools\MaguttiCmsSeoTrait;

/**
 * Class WebsiteViewModel
 * @package App\maguttiCms\Domain\Website
 */
abstract class WebsiteViewModel
{

    use MaguttiCmsSeoTrait;
    protected $currentPage;

    function __construct($page_slug = '')
    {

        if ($page_slug != '') $this->setCurrentPage($page_slug);
    }

    function getPage($slug)
    {
        return Article::findBySlug($slug, app()->getLocale());
    }

    function handleMissingPage()
    {

        return redirect('/');
    }

    /**
     * @return mixed
     */
    public function getCurrentPage()
    {
        return $this->currentPage;
    }

    /**
     * @param mixed $currentPage
     */
    public function setCurrentPage($page_slug): void
    {

        $this->currentPage = $this->getPage($page_slug);
    }

}
