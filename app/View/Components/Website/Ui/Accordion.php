<?php

namespace App\View\Components\Website\Ui;


use App\View\Components\Website\Widgets\BaseWidget;

class Accordion extends BaseWidget
{
    public $items;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($items)
    {
        $this->items=$items;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.website.ui.accordion');
    }
}
