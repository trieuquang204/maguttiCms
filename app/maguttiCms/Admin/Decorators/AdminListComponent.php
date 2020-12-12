<?php
/**
 * Created by PhpStorm.
 * User: web01
 * Date: 2019-10-15
 * Time: 09:09
 */

namespace App\maguttiCms\Admin\Decorators;
use Illuminate\Support\Str;
use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;

abstract class AdminListComponent
{
    public $model;      // current model
    public $item;       // current item properties form list config
    public $pageConfig; // current model properties form list config
    public $fieldspec;

    public $id;
    public $field;
    public $value;
    public $html;



    public function __construct($model,$item)
    {
        $this->item = $item;
        $this->setModel($model)->setField($this->item['field']);
        $this->setFieldspec();
    }
    abstract function render();
    protected function component(){
        $item = $this;
        return view('admin.list.'.$this->item['type'], compact('item'));
    }

    public function setFieldspec()
    {
        $this->fieldspec = data_get($this->model->getFieldspec(), $this->field);
        return $this;
    }

    /**
     * @param mixed $model
     * @return AdminListComponent
     */
    protected function setModel($model)
    {
        $this->model = $model;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value = $this->model->{$this->field};
    }
     /**
     * @return mixed
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @param mixed $pageConfig
     * @return AdminListComponent
     */
    public function setPageConfig($pageConfig)
    {
        $this->pageConfig = $pageConfig;
        return $this;
    }

    /**
     * @param mixed $field
     * @return AdminListComponent
     */
    public function setField($field)
    {
        $this->field = $field;
        return $this;
    }

    /**
     * @return mixed
     */
    public function isEditable()
    {
        return data_get($this->item, 'editable');
    }

    public function getItemProperty($property)
    {
        return data_get($this->item, $property);
    }

    public function getConfigProperty($property)
    {
        return data_get($this->pageConfig, $property);
    }

    public function getFieldSpecProperty($property)
    {
        return data_get($this->fieldspec, $property);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->model->id;
    }
}