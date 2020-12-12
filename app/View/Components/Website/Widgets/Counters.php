<?php

namespace App\View\Components\Website\Widgets;

use Illuminate\View\Component;

class Counters extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.website.widgets.counters');
    }

    public function getItems()
    {
        return \App\Counter::sorted()->get();
    }
}
