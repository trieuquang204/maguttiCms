<?php

namespace App\View\Components\Website\Ui;

use Illuminate\View\Component;

class FormErrorLabel extends Component
{
    public $field;

    /**
     * FormErrorLabel constructor.
     * @param $field
     */
    public function __construct($field)
    {
        //
        $this->field = $field;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.website.ui.form-error-label');
    }
}
