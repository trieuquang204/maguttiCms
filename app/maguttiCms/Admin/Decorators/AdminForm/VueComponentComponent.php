<?php
namespace App\maguttiCms\Admin\Decorators\AdminForm;

use Form;
use App;

/**
 * Class AdminTree
 * @package App\maguttiCms\Admin
 */
class VueComponentComponent extends AdminFormBaseComponent
{

    protected $active = "active";
    protected $component_name = '';

    /**
     * @param $value
     * @param $key
     * @return string
     */
    function render( $key,$value)
    {
        return $this->composeComponent($value, $key);
    }

    /**
     * @param $value
     * @param $key
     * @return string
     */
    function composeComponent($value, $key)
    {
        $data = $this->getProperty()->get('component-data');

        return "<" . $this->getComponentName() . "
                  name=\"" . $key . "\" 
                  input_text=\"" . $value . "\"
                  v-bind:data='".json_encode($data)."'
                 >
                </" . $this->getComponentName() . ">";
    }


    /**
     * @return string
     */
    public function getComponentName(): string
    {
        return $this->component_name = $this->getProperty()->get('component-name');
    }

    /**
     * @return string
     */
    public function getComponentProperties(): string
    {
        return ($this->getProperty()->get('component-data')) ? $this->getAttributes($this->getProperty()->get('component-data')) : '';
    }
}
