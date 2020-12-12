<?php

namespace App\View\Components\Website\Widgets;

use Illuminate\View\Component;

class Metrics extends Component
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
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.website.widgets.metrics');
    }



    public function getItems()
    {
        return \App\Metric::sorted()->get();
    }
}
