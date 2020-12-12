<?php

namespace App\maguttiCms\Admin\Decorators\AdminForm;

use Form;
use App;

/**
 * Class AdminTree
 * @package App\maguttiCms\Admin
 */
class CheckBox extends AdminFormBaseComponent
{

    protected $active = "active";

    public function render($value, $key)
    {

        $this->modelName = strtolower(class_basename($this->formObject->model));
        $booleanInputId = $key . '_' . $this->modelName . '_' . $this->formObject->model->id;
        //$formElement = Form::checkbox($key, 1 , $this->model->$key);
        $activeNo = ($value != '1') ? ' ' . $this->active : '';
        $activeYes = ($value == '1') ? $this->active : '';
        $checkedYes = ($value == '1') ? 'checked' : '';
        $checkedNo = ($value != '1') ? 'checked' : '';
        $this->html .= "<div class=\"btn-group\" data-toggle=\"buttons\">\n";
        $this->html .= ' <button type="button" class="btn btn-default ' . $activeYes . '" onclick="$(\'#' . $booleanInputId . '\').val(1)">
					<input type="radio" name="options" autocomplete="off" ' . $checkedYes . '>' . trans('admin.label.btn_yes') . '
				</button>';
        $this->html .= ' <button type="button" class="btn btn-default ' . $activeNo . '" onclick="$(\'#' . $booleanInputId . '\').val(0)">
					<input type="radio" name="options" autocomplete="off" ' . $checkedNo . '> ' . trans('admin.label.btn_no') . '
				</button>';
        $this->html .= "</div>\n";
        /* GF_ma aggiornato dopo Aggiunta Middleware ConvertEmptyStringsToNull metto di default 0 anzichè null */
        $value = ($value === null) ? 0 : $value;
        $this->html .= Form::hidden($key, $value, array('id' => $booleanInputId, 'class' => ' form-control ' . $this->formObject->cssClass));
        return $this->html;
    }

}
