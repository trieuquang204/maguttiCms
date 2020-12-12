<?php

namespace App\maguttiCms\Admin\Decorators\AdminForm;

use Form;

/**
 * Class MediaComponent
 * @package App\maguttiCms\Admin\Decorators\AdminForm
 */
class MediaComponent extends AdminFormBaseComponent
{
    function render($key, $value, $locale = '')
    {
        if ($this->isCropper()) {
            return view('admin.inputs.cropper', ['properties' => $this->property, 'key' => $key, 'cropperConfig' => collect($this->property['cropper'])]);
        }
        return view('admin.inputs.file', ['properties' => $this->property, 'key' => $key]);
    }

    function isCropper(){
        return isset($this->property['cropper']);
    }

}