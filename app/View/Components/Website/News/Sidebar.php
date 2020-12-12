<?php

namespace App\View\Components\Website\News;

use Illuminate\View\Component;
use App\News;

/**
 * Class Sidebar
 * @package App\View\Components\Website\News
 */
class Sidebar extends Component
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
        return view('components.website.news.sidebar');
    }

    /**
     * @param $limit
     * @return mixed
     */
    function  getLatestPost($limit){

        return News::LatestPublished($limit)->get();
    }
}
