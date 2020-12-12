<?php

namespace App\View\Components\Ui;

use Illuminate\View\Component;
/**
 * This class is used to build a dropdown input for the search section of 'model list'.
 * Class Selectable
 * @package App\View\Components\ui
 */
class Selectable extends Component
{
    public $name;
    public $selected;
    public $config;
    public $class;
    public $value;
    public $caption;

    /**
     * Selectable constructor.
     * @param $name    ==> input field name
     * @param $config  ==>  configuration attributes
     */

    public function __construct($name,$config)
    {
        $this->name = $name;
        $this->config= json_decode($config);
        $this->cssClass();
        $this->value = $this->config->value ?? 'id';
        $this->caption = $this->config->field;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.ui.selectable');
    }

    public function isSelected($option)
    {
        return $option === $this->selected;
    }

    public function cssClass()
    {
        $this->class= " form-control ".$this->config->cssClass;
    }

    public function items()
    {

        $whereRaw = $this->config->where ?? '';
        $orderField = $this->config->order_field ?? $this->config->field;
        $order = $this->config->order ?? 'ASC';
        $model = getModelFromString($this->config->model);

        return (new $model)->newQuery()
            ->when($whereRaw, function ($q, $whereRaw) {
                return $q->whereRaw($whereRaw);
            })
            ->orderby($orderField, $order)
            ->get();

    }
}
