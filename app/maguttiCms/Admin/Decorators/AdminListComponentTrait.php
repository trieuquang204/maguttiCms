<?php


namespace App\maguttiCms\Admin\Decorators;


use Carbon\Carbon;
use Illuminate\Support\Str;

/**
 * Trait AdminListComponentTrait
 * @package App\maguttiCms\Admin\Decorators
 */
trait AdminListComponentTrait
{


    function renderComponent($article, $label)
    {
        if (!is_array($label)) return $article->$label;
        if ($this->hasComponent($label['type'])) {
            return $this->initList($this->property)->makeComponent($article, $label);
        }
        return (data_get($label, 'locale')) ? $article->translate($label['locale'])->{$label['field']} : $article->{$label['field']};
    }


    function hasComponent($type)
    {
        $sample = new \ReflectionClass($this);
        if ($sample->hasMethod($this->resolveMethodName($type))){
            return true;
        }
        if ($this->componentViewExist($type)){
            return true;
        }
        if ($this->componentClassExist($type)) return true;
        return false;
    }

    function makeComponent($article, $itemProperty)
    {
        if ($this->componentClassExist($itemProperty['type'])) {
            $componentClassName = $this->resolveComponentClassNamespace($itemProperty['type']);
            return (new $componentClassName($article, $itemProperty))->setPageConfig($this->property)->render();
        }
        if($this->componentViewExist($itemProperty['type'])){
            return (new AdminListViewComponent($article, $itemProperty))->setPageConfig($this->property)->render();
        }
        return $this->{$this->resolveMethodName($itemProperty['type'])}($article, $itemProperty);
    }


    function resolveMethodName($type)
    {
        return 'make' . ucfirst(Str::camel($type));
    }


    function resolveComponentClassNamespace($type)
    {
        return "App\maguttiCms\Admin\Decorators\AdminList" . ucfirst(Str::camel($type)) . "Component";
    }

    function componentClassExist($type)
    {
        return class_exists($this->resolveComponentClassNamespace($type));
    }

    function componentViewExist($type)
    {
        return view()->exists('admin.list.'.$type);
    }

}