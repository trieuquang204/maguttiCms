<?php

namespace App\maguttiCms\Admin\Decorators\AdminForm;

use Form;

/**
 * Class SeoTextComponent
 * @package App\maguttiCms\Admin\Decorators\AdminForm
 */
class SeoTextComponent extends SeoComponent
{
    function render($key, $value= '',$locale='')
    {

        return '<seo-text-component 
                   max-count="'.$this->getMaxWordCount(config('seotools.lara_setting.description')).'" 
                   name="'.$key.'" 
                   input_text="'.$value.'">
               </seo-text-component>';

    }
}