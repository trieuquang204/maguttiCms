<?php

namespace App\View\Components\Website\Widgets;

use App\Article;
use Illuminate\View\Component;


class BaseWidget extends Component
{
    /**
     * @var Block
     */
    public $item;
    /**
     * @var
     */
    public $class;
    /**
     * @var null
     */
    public $classCaption;
    /**
     * @var null
     */
    public $color;
    /**
     * @var mixed|string
     */
    public $buttonClass;

    /**
     * BaseWidget constructor.
     * @param Article $item
     * @param string $class
     * @param null $classCaption
     * @param null $color
     * @param null $buttonClass
     */
    public function __construct(Article $item,string $class,$classCaption=null,$color=null,$buttonClass=null)
    {
        $this->item = $item;
        $this->class = $class;
        $this->classCaption = $classCaption;
        $this->color = $color;
        $this->buttonClass=$buttonClass;
    } //


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.website.widgets.design');
    }

    public function blocks()
    {
        return $this->item->blocks()->get();
    }
}
