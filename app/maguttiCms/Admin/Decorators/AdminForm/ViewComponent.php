<?php

namespace App\maguttiCms\Admin\Decorators\AdminForm;

use Form;
use App;

/**
 * Class AdminTree
 * @package App\maguttiCms\Admin
 */
class ViewComponent extends AdminFormBaseComponent
{

    protected $viewName;
    protected $viewBag = [];


    function render($key, $value, $locale)
    {
        $this->key = $key;
        $this->value = $value;
        $this->locale = $locale;
        return view($this->resolveViewName(), $this->viewBag());
    }

    function resolveViewName()
    {
        if ($this->property['type'] == 'component') return $this->viewName = 'admin.inputs.' . $this->key;
        return $this->viewName = 'admin.inputs.' . $this->property['type'];
    }

    function viewBag()
    {
        $this->viewBag = ['properties' => $this->property,
            'model' => $this->model,
            'key' => $this->key,
            'value' => $this->value,
            'css_class' => data_get($this->property, 'cssClassElement', '')
        ];
        return $this->viewBag;
    }

    function addItemToBag($key, $value)
    {
        $this->viewBag[$key] = $value;
        return $this;
    }


}
