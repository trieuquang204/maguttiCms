<?php

namespace App\View\Components\Website\Categories;

use App\Category;
use Illuminate\View\Component;

class Item extends Component
{
    /**
     * @var Category
     */
    public $category;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Category $category)
    {
        //
        $this->category = $category;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.website.categories.item');
    }
}
