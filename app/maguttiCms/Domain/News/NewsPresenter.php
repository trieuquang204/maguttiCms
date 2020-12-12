<?php
namespace App\maguttiCms\Domain\News;
use App\maguttiCms\Tools\Stringable;

trait NewsPresenter
{

    /*
    |--------------------------------------------------------------------------
    |  This method return the news permalink.
    |--------------------------------------------------------------------------
    */
    public function getPermalink($locale='')
    {
        $locale = ($locale) ? $locale : app()->getLocale();

        return url_locale('news/'. $this->{'slug:'. $locale});
    }

    /*
    |--------------------------------------------------------------------------
    |  This method return the news excerpt.
    |--------------------------------------------------------------------------
    */
    public function getExcerpt($length = 200)
    {
        return Stringable::truncate($this->description, $length);
    }

}
