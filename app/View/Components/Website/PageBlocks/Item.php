<?php

namespace App\View\Components\Website\PageBlocks;
/**
 * Class Item
 * @package App\View\Components\Website\PageBlocks
 */
class Item extends Lists
{
    public $type;
    public $block;

    /**
     * item constructor.
     * @param $item
     * @param $type
     */
    public function __construct($block, string $type)
    {
        $this->block = $block;
        $this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.website.page-blocks.' . $this->template());
    }

    public function template()
    {
        return $this->block->template->value;
    }

}