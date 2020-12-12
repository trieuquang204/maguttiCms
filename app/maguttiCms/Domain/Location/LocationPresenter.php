<?php
namespace App\maguttiCms\Domain\Location;

use App\Location;

trait LocationPresenter

{
    /*
    |--------------------------------------------------------------------------
    |  Seo & Meta
    |--------------------------------------------------------------------------
    */
    function getFullSlug($locale=''){
        /** @var  JSP  trick */
        $locale = ($locale)?:app()->getLocale();
        return preg_replace('/\{location\??\}/', $this->{'slug:'.$locale}, trans('routes.location', array(), $locale));
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

         return $page_link = $this->getPermalink();
    }
    public function display($separator)
    {
        $display = '';
        $display .= $this->street;
        if ($this->number)
            $display .= ', '.$this->number;
        $display .= $separator;
        $display .= $this->zip_code.' '.$this->city.' ('.$this->province.')';
        //$display .= $this->full_address;
        $display .= $separator;
        $display .= optional($this->country)->name;
        if ($this->phone) {
            $display .= $separator;
            $display .= $this->phone;
        }
        if ($this->mobile) {
            $display .= $separator;
            $display .= $this->mobile;
        }
        if ($this->email) {
            $display .= $separator;
            $display .= ''.$this->email;
        }
        if ($this->link) {
            $display .= $separator;
            $display .= '<a href="'. $this->link.'" class="color-6 text-break" target="_new">'. $this->link.'</a>';
        }

        return $display;
    }

    public function getDisplayInlineAttribute()
    {
        return $this->display(' - ');
    }

    public function getDisplayBlockAttribute()
    {
        return $this->display('<br>');
    }
}
