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
class RelationCheckBoxesComponent extends SelectBaseComponent
{

    use AdminFormRelation;

    function render($key, $value)
    {
       $objRelation   = $this->getRelation();
       $selected      = $this->model->{$this->property['relation_name']}->pluck('id')->toArray();
       return  view('admin.inputs.checkboxes_grid', ['properties' => $this->property, 'objRelation' => $objRelation , 'selected' => $selected, 'key' => $key]);
    }

}
