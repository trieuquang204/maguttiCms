<?php

namespace App\View\Components\Admin\Partial;

use Illuminate\View\Component;

class PageBlockList extends Component
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
        $this->item= $item;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.admin.partial.page-block-list');
    }
}
