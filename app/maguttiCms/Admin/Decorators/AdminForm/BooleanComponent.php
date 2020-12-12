<?php

namespace App\maguttiCms\Admin\Decorators\AdminForm;

use Form;

/**
 * Base input class
 * Class InputComponent
 * @package App\maguttiCms\Admin\Decorators\AdminForm
 */
class BooleanComponent extends InputComponentAdminForm
{
    function render($key, $value, $locale = '')
    {
        return  (new CheckBox($this->formObject))->render($value,$key);
    }


}