<?php namespace App\maguttiCms\Admin\Helpers;

use Illuminate\Support\Str;

/**
 *
 * Class AdminUserHelperTrait
 * @package App\maguttiCms\Admin\Helpers
 */
trait AdminRelationsSaverTrait
{
	public static function bootAdminRelationsSaverTrait()
	{
	}

	public function relationsSaver($model)
	{
		foreach ($this->getMultipleRelation() as $key => $value) {
			$value = collect($value);
			$method = $this->getRelationSaveMethod($key, $value);

			if (method_exists($model, $method)) {

				if (!$value->has('roles') || auth_user('admin')->hasRole($value->get('roles'))) {
				    if($this->relationMethodAsAbility($model,$method)){
                        $methodAbility = $this->getRelationMethodGetAbility($method);
                        if($model->{$methodAbility}( $this->request->get($key) )){
                            $model->{$method}($this->request->get($key));
                        };
                    }
				    else $model->{$method}($this->request->get($key));
				}
			}
		};
	}

	public function getRelationSaveMethod($key, $value)
	{
		return  ($value->has('relationSaveMethod'))? $value->get('relationSaveMethod'): 'save'.ucfirst(Str::plural($key)) ;
	}

	public function getMultipleRelation()
	{
		return collect($this->fieldSpecs)->whereIn('type',['relation_checkboxes','relation'])->where('multiple', 1)->all();
	}

	public function relationMethodAsAbility($model,$method)
    {
        $Reflector = new \ReflectionClass($model);
        return $Reflector->hasMethod($this->getRelationMethodGetAbility($method));
    }

    public function getRelationMethodGetAbility($method)
    {
        return $method."Ability";
    }

}
