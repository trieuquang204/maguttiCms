<?php

namespace App\View\Components\Website\Widgets;

use App\Category;
use Illuminate\View\Component;

class Masonry extends Component
{
    public $category;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($category)
    {
       $this->category = $category;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.website.widgets.masonry');
    }

    function projects(){
       return  $this->category->products()->published()->orderBy('sort')->get();;
    }

    function nextItem(){
        $categories = collect(Category::published()->orderBy('sort')->pluck('id'));
        return $this->category->getNextItem($categories);

    }
}
