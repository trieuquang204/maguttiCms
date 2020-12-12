<?php
/**
 * Created by PhpStorm.
 * User: web01
 * Date: 2019-10-15
 * Time: 09:09
 */

namespace App\maguttiCms\Admin\Decorators;

class AdminListBooleanComponent extends AdminListComponent
{

    public $relationObj;
    public $model_name;

    public function render()
    {
        return $this->setRelationObj()->component();
    }
    protected function component()
    {
        $this->model_name = ($this->relationObj)?$this->item['model']:$this->getConfigProperty('model');
        $item = $this;
        if ($this->getItemProperty('relation') && $this->relationObj || !$this->getItemProperty('relation')) {
            $this->html = view('admin.list.boolean',compact('item'));
        }

        return $this->html;
    }
    /**
     * @return $this
     */
    protected function setRelationObj()
    {
        $this->relationObj = ($this->getItemProperty('relation')) ? AdminDecorator::getBooleanRelation($this->model,$this->item) : null;
        return $this;
    }

    public function getValue()
    {
        return $this->value = ($this->relationObj) ? $this->relationObj->{$this->field} : $this->model->{$this->field};
    }

    public function getId()
    {
        return  $this->id = ($this->relationObj) ? $this->relationObj->id : $this->model->id;
    }
}
