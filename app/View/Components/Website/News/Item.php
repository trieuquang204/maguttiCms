<?php

namespace App\View\Components\Website\News;

use Illuminate\View\Component;

use App\News;
class Item extends Component
{
    /**
     * @var News
     */
    public $post;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(News $post)
    {
        //
        $this->post = $post;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.website.news.item');
    }
}
