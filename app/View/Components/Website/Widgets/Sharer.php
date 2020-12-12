<?php

namespace App\View\Components\Website\Widgets;

use Illuminate\View\Component;

class Sharer extends Component
{
   public $item;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($item)
    {

        $this->item = $item;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.website.widgets.sharer');
    }
}
