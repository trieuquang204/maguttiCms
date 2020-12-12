<?php

namespace App\View\Components\Website\PageBlocks;

use Illuminate\View\Component;

class Lists extends Component
{
    public $item;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($item)
    {
        //
        $this->item = $item;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.website.page-blocks.lists');
    }

    public function items()
    {
        return optional($this->item)->blocks;
    }


}
