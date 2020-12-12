<?php namespace App\maguttiCms\Domain\Article;

use App\Article;

trait ArticlePresenter
{

    /*
    |--------------------------------------------------------------------------
    |  This method return the page slug.
    |--------------------------------------------------------------------------
    */
    function getFullSlug($locale=''){
        $locale = ($locale)?:app()->getLocale();

        if ($this->parent && $this->parent->{'slug:it'} != 'home')
        return $this->parent->{'slug:'.$locale}.'/'.$this->{'slug:'.$locale};

        if ($this->{'slug:'.$locale} == 'home')
        return '';

        return $this->{'slug:'.$locale};
    }

    /*
    |--------------------------------------------------------------------------
    |  This method return the page permalink.
    |--------------------------------------------------------------------------
    */
    public function getPermalink($locale='')
    {
        $url = ($this->sluggable['slug']['translatable']) ? $this->getFullSlug($locale) : $this->slug;
        return url_locale($url);
    }

    /*
    |--------------------------------------------------------------------------
    |  This method return the page permalink by id.
    |--------------------------------------------------------------------------
    */
    public static function getPermalinkById($page_id,$locale='')
    {
        $page = Article::find($page_id);
        return $page->getPermalink($locale);
    }


    /**
     * This method is used to get menu item link.
     *
     *
     * @return mixed
     */
    function getNavTitleAttribute()
    {
        return ($this->menu_title) ? $this->menu_title : $this->title;
    }


    function getBtnTitleAttribute()
    {
        return ($this->menu_title) ? $this->menu_title : $this->sub_title;
    }


    /**
     * This method is used to get menu item link.
     *
     *
     * @return string
     */

    function getNavLinkAttribute()
    {
        if ($this->slug == 'home') {
            return $page_link = '/';
        } elseif ($this->link) {
            return $page_link = $this->link;
        } else {
            return $page_link = $this->getPermalink();
        }
    }




    function getNavCssClassAttribute()
    {
      return "nav-item-".$this->{'slug:'. config('app.locale')};
    }

    /**
    * GESTIONE OPZIONALE META
    * PER I SOCIALS
    */
    function  metaTagGinius(){

        $description = "";
        $title =  "";
        \SEO::opengraph()->addProperty('title',$title);
        \SEO::opengraph()->addProperty('description',$description);
        \SEO::twitter()->addValue('title',$title);
        \SEO::twitter()->addValue('description',$description);
    }


    /**
     *
     *  his method is used to get seo alt title.
     *
     * @return mixed
     */

    function getAltSeoTitleAttribute()
    {
        return ($this->seo_title)?:$this->nav_title;
    }
}
