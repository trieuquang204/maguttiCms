<?php namespace App\maguttiCms\Admin\Decorators\AdminForm;

use Form;
use App;


/**
 * Class AdminTree
 * @package App\maguttiCms\Admin
 */
class AdminFormBaseComponent

{
    protected $field_properties = [];
    protected $property;
    protected $formObject;
    protected $html;
    protected $modelName;
    protected $attributes;
    protected $selected;
    protected $model;
    protected $key;
    protected $value;
    protected $locale;

    /**
     * BaseComponent constructor.
     * @param $formObject
     */
    public function __construct($formObject)
    {
        $this->formObject = $formObject;
        $this->property = collect($this->formObject->getProperty());
        $this->model = $this->formObject->model;
    }


    /**
     * @return mixed
     */
    public function getProperty()
    {
        return $this->property;
    }

    /**
     * @param $options
     * @return string
     */
    public function getAttributes($options)
    {
        foreach ($options as $name => $value) {
            if (is_bool($value)) {
                if ($value) $this->attributes .= $name . ' ';
            } else {
                $this->attributes .= sprintf('%s="%s"', $name, $value);
            }
        };
        return $this->attributes;
    }


}
