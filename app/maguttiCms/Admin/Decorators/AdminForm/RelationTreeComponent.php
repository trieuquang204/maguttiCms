<?php

namespace App\maguttiCms\Admin\Decorators\AdminForm;

use Form;
use App;

use App\maguttiCms\Admin\Helpers\AdminTree;
use App\maguttiCms\Admin\Helpers\AdminFormRelation;


/**
 * Class AdminTree
 * @package App\maguttiCms\Admin
 */
class RelationTreeComponent extends SelectBaseComponent
{

    use AdminFormRelation;

    function render($key, $value)
    {
        $this->selected();
        $objRelation = $this->getRelation();
        $objRelationTree = (new AdminTree($this->formObject))->getTreeRelation($objRelation, 0);
        return (new SelectBaseComponent($this->formObject))->get($objRelationTree, $key, $value, $this->selected);
    }

}
