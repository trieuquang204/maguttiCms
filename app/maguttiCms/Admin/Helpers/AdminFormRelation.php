<?php


namespace App\maguttiCms\Admin\Helpers;


use Illuminate\Support\Str;

/**
 * Trait AdminFormContext
 * @package App\maguttiCms\Admin\Helpers
 */
trait AdminFormRelation
{
    public function getRelation( $selected = '' ) {
        $relationModel = "App\\".ucfirst($this->property['model']) ;
        $model = new $relationModel;

        $orderField = (data_get($this->property,'order_field'))? $this->property['order_field']: $this->property['label_key'];
        $order = 'ASC';
        $query = $model::select(); //$relationModel;

        if (data_get($this->property,'orderRaw') && count($selected)) {
            $orderRaw = sprintf($this->property['orderRaw'], implode(', ', $selected));
        } else {
            $orderRaw = false;
        }

        if (isset($model->translatedAttributes) && in_array($this->property['label_key'],$model->translatedAttributes)) {
            return $this->getTranslatableRelation();
        } else {
            /** filter condition */
            if (isset($this->property['filter'])){
                foreach($this->property['filter'] as $column => $value)
                {
                    $query->where($column, '=', $value);
                }
            }
            if (data_get($this->property,'whereRaw')){
                $query->whereRaw($this->property['whereRaw']);
            }
            if ($orderRaw) {
                $relationObj = $query->orderByRaw($orderRaw)->get();
            } else {
                $relationObj = $query->orderBy($orderField,$order)->get();
            }

            return $relationObj;
        }
    }

    /**
     * GET RELATION DATA FOR
     * TRANSLATABLE TABLE
     * CAN BE FILTERED
     * AND ORDERED
     * @return mixed
     */
    function getTranslatableRelation(){
        $relationModel = "App\\".$this->property['model'] ;
        $orderField = (isset($this->property['order_field']))? $this->property['order_field']: $this->property['label_key'];
        $order = 'ASC';
        $table = with(new $relationModel)->getTable();
        $translationTable = strtolower(Str::snake($this->property['model']));
        $a = (isset($this->property['foreign_key'])) ? $this->property['foreign_key'] : 'id';
        $query = $relationModel::join($translationTable.'_translations as t', 't.'.$translationTable.'_id', '=', $table.'.id')
            ->where('locale', app()->getLocale())
            ->groupBy($table.'.id')
            ->with('translations');

        if ($a!='id') $query->select($table.'.'.$a, $table.'.id', 't.'.$this->property['label_key'].' as '.$this->property['label_key']);
        else $query->select($table.'.id', 't.'.$this->property['label_key'].' as '.$this->property['label_key']);

        if (data_get($this->property,'tree_field')) $query->addSelect($table.'.'.$this->property['tree_field']);
        if (data_get($this->property,'tree_field')) $query->addSelect($table.'.'.$orderField);

        if (isset($this->property['filter'])){
            foreach($this->property['filter'] as $column => $value)
            {
                $query->where($column, '=', $value);
            }
        }

        if (data_get($this->property,'whereRaw')){
            $query->whereRaw($this->property['whereRaw']);
        }

        $relationObj = $query->orderBy($orderField,$order)->get();
        return $relationObj ;
    }
}