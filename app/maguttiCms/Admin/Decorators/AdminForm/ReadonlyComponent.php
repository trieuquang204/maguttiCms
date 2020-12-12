<?php

namespace App\maguttiCms\Admin\Decorators\AdminForm;

use Form;

class ReadonlyComponent extends InputComponentAdminForm
{
    function render($key, $value, $locale = '')
    {
        $this->add_field_property('readonly', true);
        return Form::text($key, $value, $this->field_properties());
    }
}