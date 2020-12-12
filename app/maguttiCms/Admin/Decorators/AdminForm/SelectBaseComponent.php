<?php namespace App\maguttiCms\Admin\Decorators\AdminForm;

use Form;
use App;

/**
 * Class AdminTree
 * @package App\maguttiCms\Admin
 */
class SelectBaseComponent extends AdminFormBaseComponent
{

    protected $active = "active";
    protected $selected = '';
    protected $value = '';


    public function get($obj, $field, $selItem = '', $selectedArray = '')
    {

        $a = data_get($this->property, 'foreign_key', 'id');
        $b = data_get($this->property, 'label_key', 'name');
        $isRequired = data_get($this->property, 'required', false);
        $nullLabel = data_get($this->property, 'nullLabel', 'Select ' . $this->property['label']);
        $multiple = (data_get($this->property, 'multiple', ''))?'multiple':'';
        $cssClass = data_get($this->property, 'cssClass', '');

        // GF_ma gestione campo hidden
        if (data_get($this->property, 'hidden') == 1) {
            if ($multiple) $html = "<select class=\"form-control hidden\" id=\"" . $field . "\" name=\"" . $field . "[]\" " . $multiple . " >\n";
            else $html = "<select class=\"form-control hidden\" id=\"" . $field . "\" name=\"" . $field . "\" >\n";
        } else {
            if ($multiple) $html = "<select data-placeholder=\"Select an option\" class=\"form-control selectizemulti\" id=\"" . $field . "\" name=\"" . $field . "[]\" " . $multiple . ">\n";
            else $html = "<select class=\"form-control " . $cssClass . " \" id=\"" . $field . "\" name=\"" . $field . "\" >\n";
        }

        if (!$isRequired) $html .= "<option value=\"\">" . $nullLabel . "</option>";

        foreach ($obj as $item) {
            $selected = ($item->$a == $selItem || (is_array($selectedArray) && in_array($item->$a, $selectedArray))) ? 'selected' : '';
            $html .= "<option value=\"" . $item->$a . "\" " . $selected . ">" . $item->$b . "</option>\n";
        }
        $html .= "</select>\n";
        return $html;
    }


    function selected()
    {

        return $this->selected = (data_get($this->property, 'relation_name') != '') ? $this->model->{$this->property['relation_name']}->pluck('id')->toArray() : '';

    }


}
