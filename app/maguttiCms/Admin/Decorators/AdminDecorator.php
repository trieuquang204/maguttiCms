<?php
/**
 * Created by PhpStorm.
 * User: web01
 * Date: 05/08/16
 * Time: 11:22
 */

namespace App\maguttiCms\Admin\Decorators;

class AdminDecorator
{
    protected $html;
    protected $model;
    protected $property;

    /**
     * @return mixed
     */
    public function render()
    {
        return $this->html;
    }


    public function getRelation($property)
    {
        $this->property = $property;
        $relationModel = "App\\" . $this->property['model'];
        $model = new  $relationModel;
        $orderField = (isset($this->property['order_field'])) ? $this->property['order_field'] : $this->property['label_key'];
        $order = 'ASC';

        $query = $model::select(); //$relationModel;
        /**  filter  condition */
        $this->addFilters($query)->addQueryScope($query);
        $relationObj = $query->orderBy($orderField, $order)->get();
        return $relationObj;
    }

    public function getBooleanRelation($item, $property)
    {
        $this->property = $property;
        $relationObj = $item->{$property['relation']};
        return $relationObj;
    }

    public function getSelectRelationItem($property,$item_id ="")
    {
        $this->property = $property;
        if($item_id) {
            $relationModel =  "App\\" . $this->property['model'];
            return $relationModel::find($item_id);
        }
        return  false;

    }
    public function getSelectRelationItemValue($property,$item_id ="",$field='value')
    {
        if($item_id){
            $item = self::getSelectRelationItem($property,$item_id);
            if($item){
                return $item->{$field};
            }
        }
        return false;

    }

    public function selectedHandler($key, $value, $selected = 'selected')
    {
        return ($key == $value) ? $selected : '';
    }

	public function getBooleanOn()
	{
		$string = '';
		if (config('maguttiCms.admin.option.list.show-bool-icons')) {
			$string .= icon('check');
		}
		if (config('maguttiCms.admin.option.list.show-bool-labels')) {
			$string .= trans('admin.label.active_on');
		}
		return $string;
	}

	public function getBooleanOff()
	{
		$string = '';
		if (config('maguttiCms.admin.option.list.show-bool-icons')) {
			$string .= icon('times');
		}
		if (config('maguttiCms.admin.option.list.show-bool-labels')) {
			$string .= trans('admin.label.active_off');
		}
		return $string;
	}


    //  aggiunge un query scope alla  query
    public function addQueryScope($query)
    {
        if (data_get($this->property,'scopes')) {
            foreach ($this->property['scopes'] as $scope) {
                $query->{$scope}();
            }
        }
        return $this;
    }

    public function addFilters($query)
    {
        if (data_get($this->property,'filter')) {
            foreach ($this->property['filter'] as $column => $value) {
                $query->where($column, '=', $value);
            }
        }
        return $this;
    }

}
