<?php

namespace App\maguttiCms\Admin\Decorators\AdminForm;

use Carbon\Carbon;
use Form;


class DateComponent extends InputComponentAdminForm
{
    function render($key, $value, $locale = '')
    {
        $date = $this->getValue($value);
        return Form::text($key, $date, $this->field_properties());
    }

     function getValue($value){
        return  ($value) ? Carbon::parse($value)->format('d-m-Y') :date('d-m-Y');
     }

}