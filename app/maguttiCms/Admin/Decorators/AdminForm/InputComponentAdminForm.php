<?php

namespace App\maguttiCms\Admin\Decorators\AdminForm;

use Form;

/**
 * Base input class
 * Class InputComponent
 * @package App\maguttiCms\Admin\Decorators\AdminForm
 */
class InputComponentAdminForm extends AdminFormBaseComponent
{
    function render($key, $value, $locale = '')
    {
        return Form::text($key, $value, $this->field_properties());
    }

    function field_properties()
    {
        $cssClass = data_get($this->property, 'cssClass', '');
        $this->field_properties['class'] = 'form-control ' . $cssClass;
        $this->extra_field_properties();

        return $this->field_properties;
    }

    /**
     * @param $properties
     * @param $value
     * @return $this
     */
    function add_field_property($properties, $value)
    {
        $this->field_properties[$properties] = $value;
        return $this;
    }

    /**
     * this method
     * @return $this
     */
    function extra_field_properties()
    {
        if ($this->property->has('extra_field_properties')) {
            collect($this->property['extra_field_properties'])->each(function ($value, $key) {
                $this->add_field_property($key, $value);
            });

        }
        return $this;
    }
}