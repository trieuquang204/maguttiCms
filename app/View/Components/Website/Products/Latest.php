<?php

namespace App\View\Components\Website\Products;

use App\Product;
use Illuminate\View\Component;

class Latest extends Component
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
        return view('components.website.products.latest');
    }

    function  products($limit=20){
        return Product::published()->inRandomOrder()->limit($limit)->get();
    }
}
