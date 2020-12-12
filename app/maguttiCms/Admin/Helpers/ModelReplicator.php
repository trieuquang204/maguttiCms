<?php namespace App\maguttiCms\Admin\Helpers;

/**
 *
 * Class AdminUserHelperTrait
 * @package App\maguttiCms\Admin\Helpers
 */
trait ModelReplicatorTrait
{
    /*
    |--------------------------------------------------------------------------
    | Duplicazione contenuti con campi uniques
    |--------------------------------------------------------------------------
    */

    public $uniqueFields; // campi da non duplicare

    public function duplicateModel($model_id)
    {
        $model = $this->modelClass::find($model_id);
        $this->uniqueFields = $this->getUniquesFields($model);
        $new_model = $model->replicate($this->uniqueFields);
        $new_model->save();
        return $new_model;
    }

    protected function getUniquesFields($model)

    {
        $collection = collect($model->getFieldSpec());
        $filtered = $collection->where('unique', true)->all();
        return array_keys($filtered);
    }
}