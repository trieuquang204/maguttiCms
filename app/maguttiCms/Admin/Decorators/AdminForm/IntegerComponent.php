<?php

namespace App\maguttiCms\Admin\Decorators\AdminForm;

use Form;

/**
 * Class IntegerComponent
 * @package App\maguttiCms\Admin\Decorators\AdminForm
 */
class IntegerComponent extends InputComponentAdminForm
{
    function render($key, $value, $locale = '')
    {
        $this->setDefault();
        return Form::number($key, $value, $this->field_properties());
    }

    // number input need to have the min, max and step
    // attributes. Attributes  can be empty
    // if you don't need a range
    function setDefault()
    {

        if (!$this->property->has('extra_field_properties')) {
            $this->property['extra_field_properties'] = [
                'min' => '',
                'max' => '',
                'step' => ''
            ];
        }
    }
}