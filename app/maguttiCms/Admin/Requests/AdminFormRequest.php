<?php namespace App\maguttiCms\Admin\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Input;

/**
 * Class AdminFormRequest
 * @package App\maguttiCms\Admin\Requests
 */
class AdminFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized
     * to make this request.
     *
     * @return bool
     */
    protected $rules = [];

    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that
     * apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $obj = $this->getModelObject();
        foreach ($obj->getFieldspec() as $key => $field) {
            if (data_get($field, 'validation') != '') {
                $this->handleValidationRules($field['validation'], $key);
            } else if (data_get($field, 'required') && in_array($key, $obj->getFillable())) {
                $this->addRule($key);
            }
        }
        return $this->rules;
    }

    function handleValidationRules($validation_rules, $key)
    {
        if (is_array($validation_rules)) {
            foreach ($validation_rules as $item => $value) {
                $this->addRule($item, $value);
            }
        } else $this->addRule($key, $validation_rules);
    }

    function addRule($key, $validation_rules = 'required')
    {
        $this->rules[$key] = $validation_rules;
    }

    /**
     * Resolve the model to validate
     * from path
     * @return mixed
     */
    function getModelObject()
    {
        $model = ($this::segment(2) == 'create') ? $this::segment(count($this::segments())) : $this::segment(count($this::segments()) - 1);
        $curModel = getModelFromString(config('maguttiCms.admin.list.section.' . $model)['model']);
        return new $curModel;
    }
}