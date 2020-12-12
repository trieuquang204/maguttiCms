<?php

namespace App\View\Components\Website\Partials;

use App\Block;
use Illuminate\View\Component;

class PageBlock extends Component
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
     * PageBlock constructor.
     * @param Block $item
     * @param $class
     * @param null $classCaption
     * @param null $color
     * @param null $buttonClass
     */
    public function __construct(Block $item,$class,$classCaption=null,$color=null,$buttonClass=null)
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
        return view('components.website.partials.page-block');
    }
}
