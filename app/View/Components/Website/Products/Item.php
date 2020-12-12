<?php

namespace App\View\Components\Website\Products;

use App\Product;

use Illuminate\View\Component;

class Item extends Component
{
    /**
     * @var Product
     */
    public $product;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Product $product)
    {
        //
        $this->product = $product;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.website.products.item');
    }
}
