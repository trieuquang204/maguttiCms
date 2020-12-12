<?php

namespace App\maguttiCms\Admin\Decorators\AdminForm;

use Form;




/**
 * Abstract base class for seop component
 * Class SeoComponent
 * @package App\maguttiCms\Admin\Decorators\AdminForm
 */
abstract class SeoComponent extends InputComponentAdminForm
{

    /**
     * @param $default
     * @return mixed
     */
    function getMaxWordCount($default){
        return data_get($this->property,'max',$default);
    }

}