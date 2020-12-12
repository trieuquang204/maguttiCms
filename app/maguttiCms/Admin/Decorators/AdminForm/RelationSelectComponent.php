<?php

namespace App\maguttiCms\Admin\Decorators\AdminForm;

use Form;
use App;

use App\maguttiCms\Admin\Helpers\AdminFormRelation;


/**
 * Class AdminTree
 * @package App\maguttiCms\Admin
 */
class RelationSelectComponent extends SelectBaseComponent
{
    use AdminFormRelation;

    function render($key, $value)
    {
        $this->selected();
        $objRelation = $this->getRelation($this->selected);
        return (new SelectBaseComponent($this->formObject))->get($objRelation, $key, $value, $this->selected);
    }

}
