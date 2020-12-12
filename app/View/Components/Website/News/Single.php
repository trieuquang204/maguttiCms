<?php

namespace App\View\Components\Website\News;

use App\News;
use Illuminate\View\Component;

/**
 * Class Single
 * @package App\View\Components\Website\News
 */
class Single extends Component
{
    /**
     * @var News
     */
    public $news;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(News $news)
    {
        //
        $this->news = $news;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.website.news.single');
    }
}
