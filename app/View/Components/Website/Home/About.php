<?php

namespace App\View\Components\Website\Home;

use App\View\Components\Website\Widgets\BaseWidget;

class About extends BaseWidget
{

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.website.home.about');
    }
}
