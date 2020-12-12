<?php

namespace App\View\Components\Website\Home;

use Illuminate\View\Component;

use App\HpSlider;


/**
 * Class Slider
 * @package App\View\Components\Website\Home
 */

class Slider extends Component
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
        return view('components.website.home.slider');
    }

    /**
     * get th HP slides
     * @return mixed
     */
    public function slides(){

        return HpSlider::active()->get();
    }
}
