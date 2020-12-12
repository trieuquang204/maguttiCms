<?php

namespace App\View\Components\Ui;

use Illuminate\View\Component;

/**
 * This class is used to build a suggestable field (it uses select 2).
 * Class Selectable
 * @package App\View\Components\ui
 */

class Suggestable extends Component
{
    public $name;
    public $selected;
    public $config;
    public $class;
    public $value;
    public $caption;

     /**
     * Suggestable constructor.
     * @param $name ==> input field name
     * @param $config ==>  configuration attributes
     */

    public function __construct($name, $config)
    {
        $this->name = $name;
        $this->config = json_decode($config);
        $this->value = $this->config->value ?? 'id';
        $this->caption = $this->config->caption;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.ui.suggestable');
    }

    public function isSelected($option)
    {
        return $option === $this->selected;
    }
}
