<?php

namespace App\View\Components\Website\Carousels;

use Illuminate\View\Component;

class Carousel extends Component
{
    public $item;
    public $carousel_items;
    public $limit;

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
        return view('components.website.carousels.carousel');
    }


}
