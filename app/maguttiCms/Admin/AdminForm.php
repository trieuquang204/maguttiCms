<?php namespace App\maguttiCms\Admin;

use Form;
use Str;
use App;


use App\maguttiCms\Admin\Helpers\AdminFormContext;
use App\maguttiCms\Admin\Helpers\AdminFormRelation;
use App\maguttiCms\Admin\Helpers\AdminFormResolverComponentTrait;


/**
 * Generete the admin form for a given
 * Model
 *
 * Class AdminForm
 *
 * @package App\maguttiCms\Admin
 */
class AdminForm
{

    public $model;
    public $cssClass;
    protected $html;
    protected $property;
    protected $showSeo;
    protected $headerLabelRow;
    protected $cssRow;

    use AdminFormContext, AdminFormRelation, AdminFormResolverComponentTrait;

    public function get($model)
    {
        $this->showSeo = false;
        $this->initForm($model);
        echo $this->render();
    }

    public function getSeo($model)
    {
        $this->showSeo = true;
        $this->initForm($model);
        echo $this->render();
    }


    public function render()
    {
        return $this->html;
    }

    public function cssRow()
    {
        return $this->cssRow = (isset($this->property['cssRow'])) ? $this->property['cssRow'] : '';
    }

    public function headerLabelRow()
    {
        return $this->headerLabelRow = (isset($this->property['headerLabel'])) ? "<h3 class=\"ml10 mb20\">" . $this->property['headerLabel'] . "</h3>" : '';
    }


    protected function initForm($model)
    {
        $this->html = "";
        $this->model = $model;
        foreach ($this->model->getFieldSpec() as $key => $property) {
            if ($this->handleContext($key, $property)) $this->formModelHandler($property, $key, $this->model->$key);
        }
        // init lang only if context it's empty
        if ($this->context == '') $this->initLanguages();
    }

    /*
    |--------------------------------------------------------------------------
    | HANDLE THE LANG SECTION
    |--------------------------------------------------------------------------
    */
    public function initLanguages()
    {
        if (isset($this->model->translatedAttributes) && count($this->model->translatedAttributes) > 0) {
            $this->model->fieldspec = $this->model->getFieldSpec();
            foreach (config('app.locales') as $locale => $value) {
                if (config('app.locale') != $locale) {
                    $target = "language_box_" . Str::slug($value) . "_" . Str::random(160);
                    $this->html .= $this->containerLanguage($locale, $value, $target);
                    $this->html .= "<div class=\"collapse language_box\" id=\"" . $target . "\">";
                    foreach ($this->model->translatedAttributes as $attribute) {
                        $value = (isset($this->model->translate($locale)->$attribute)) ? $this->model->translate($locale)->$attribute : '';
                        $this->property = $this->model->fieldspec[$attribute];
                        if (Str::startsWith($attribute, 'seo') == $this->showSeo)
                            $this->formModelHandler($this->model->fieldspec[$attribute], $attribute . '_' . $locale, $value, $locale);
                    }
                    $this->html .= "</div>";
                }
            }
        }
    }
    /*
    |--------------------------------------------------------------------------
    | COMPONENT SECTION
    | COMPONENT CAN BE GENERATED BY DEDICATE CLASS
    | OR BY VIEW IN ADMIN.INPUT FOLDER
    |--------------------------------------------------------------------------
    */
    private function formModelHandler($property, $key, $value = '', $locale = '')
    {
        $this->property = $property;
        // populate field default value if the model is empty
        $value = (isset($this->property['default_value']) && empty($this->model->id)) ? $this->property['default_value'] : $value;
        $cssClassElement = data_get($this->property, 'cssClassElement');
        $field_properties = ['class' => ' form-control ' . data_get($this->property, 'cssClass')];

        // return if display property is false
        if (data_get($this->property, 'lang') || $this->property['display'] != 1) return;

        // generate component
        $formElement = $this->renderComponent($value, $key, $field_properties, $locale);

        // add component to html bag
        $this->html .= $this->container($formElement, $cssClassElement, $key, $value, $locale);

    }


    /*
    |--------------------------------------------------------------------------
    | CONTAINER SECTION
    | WRAP THE COMPONENT INTO CONTAINER
    |--------------------------------------------------------------------------
    */

    function container($formElement, $cssClassElement, $key, $value, $locale = '')
    {
        // Don't wrap component if hidden
        if (data_get($this->property, 'hidden')) return $formElement;

        if ($this->property['type'] == 'media') {
            return  $this->containerMedia($formElement, $cssClassElement, $key, $value, $locale);
        }

        return view('admin.inputs.container', ['properties' => $this->property, 'form_element' => $formElement, 'css_class' => $cssClassElement]);
    }

    function containerMedia($formElement, $cssClassElement, $key, $value, $locale = '')
    {
        $media_view = (data_get($this->property, 'uploadifive')) ? 'upload' :'media';
        return view('admin.inputs.container_'.$media_view,
                         ['properties' => $this->property,
                          'form_element' => $formElement,
                          'css_class' => $cssClassElement,
                          'key' => $key,
                          'value' => $value,
                          'model' => $this->model,
                          'locale' => $locale]);
    }


    /**
     * @return mixed
     */
    function extraMsgHandler()
    {
        return data_get($this->property,'extraMsg');
    }
    /*
    |--------------------------------------------------------------------------
    | LANGUAGE SECTION HELPER
    |--------------------------------------------------------------------------
    */

    function containerLanguage($locale, $label, $target)
    {
        return view('admin.inputs.language_header', ['locale' => $locale, 'label' => $label, 'target' => $target]);
    }
    /**
     * @return mixed
     */
    public function getProperty()
    {
        return $this->property;
    }
}