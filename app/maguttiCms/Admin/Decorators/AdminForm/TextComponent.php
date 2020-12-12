<?php

namespace App\maguttiCms\Admin\Decorators\AdminForm;

use Form;

class TextComponent extends InputComponentAdminForm
{
    function render($key, $value, $locale = '')
    {

        $height = 'height:' . data_get($this->property, 'h', '300') . 'px';

        $this->extra_field_properties('style', $height);

        return Form::textarea($key, $value . '', $this->field_properties());
    }

}