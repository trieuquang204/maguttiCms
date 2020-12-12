<?php
/**
 * Created by PhpStorm.
 * User: web01
 * Date: 2019-10-15
 * Time: 09:09
 */

namespace App\maguttiCms\Admin\Decorators;

class AdminListRelationComponent extends AdminListComponent
{
    public $relationObj;

    public function render()
    {
        return $this->component();
    }

    protected function component()
    {
        if ($this->isEditable()) {
            $this->relationObj = (new AdminDecorator)->getRelation($this->item);
            $item = $this;
            $this->html = view('admin.list.select', compact('item'));
            return $this->html;
        }
        return $this->getRelationValue();
    }


    function getRelationValue()
    {

        $relation = $this->getItemProperty('relation');
        if ($this->getItemProperty('multiple') != '') {
            $data = optional($this->model->$relation)->pluck($this->getField())->sortBy($this->getField())->toArray();
            return $this->value = implode(',', $data);
        }
        return $this->value = optional($this->model->$relation)->{$this->getField()};
    }

}
