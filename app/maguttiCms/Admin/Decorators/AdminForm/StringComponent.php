<?php

namespace App\maguttiCms\Admin\Decorators\AdminForm;

use Form;

class StringComponent extends InputComponentAdminForm
{
    function render($key, $value, $locale = '')
    {

        return Form::text($key, $value, $this->field_properties());
    }

}