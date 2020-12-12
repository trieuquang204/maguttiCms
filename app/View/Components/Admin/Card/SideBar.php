<?php

namespace App\View\Components\Admin\Card;

use Illuminate\View\Component;

class SideBar extends Component
{
    public $id;

    /**
     * SideBar constructor.
     * @param string $id
     */
    public function __construct($id='')
    {
        //
        $this->id = $id;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.admin.card.side-bar');
    }
}
