<?php
namespace App\maguttiCms\Domain\Category;

trait CategoryPresenter

{
    /*
    |--------------------------------------------------------------------------
    |  Seo & Meta
    |--------------------------------------------------------------------------
    */
    function getFullSlug($locale=''){
		/** @var  JSP  trick */
        $locale = ($locale)?:app()->getLocale();
        return preg_replace('/\{category\??\}/', $this->{'slug:'.$locale}, trans('routes.category', array(), $locale));
    }

    public function getPermalink($locale='')
    {
        $url =  $this->getFullSlug($locale);
        return url_locale($url);
    }
    function getNavTitleAttribute()
    {
        return ($this->menu_title) ? $this->menu_title : $this->title;
    }
    function getNavLinkAttribute()
    {
        return $page_link = ($this->link)? $this->link : $this->getPermalink();
    }
}
