<?php


namespace App\maguttiCms\Admin\Helpers;

/**
 * Trait AdminListAction
 * @package App\maguttiCms\Admin\Helpers
 */
trait AdminListAction
{

    protected $action_list = ['edit', 'delete', 'view', 'copy', 'impersonate'];

    /**
     * check if the model list
     * has an action
     * @return bool
     */
    function hasActions()
    {
        return collect($this->action_list)->some(function ($value) {
            return data_get($this->property['actions'], $value,'');
        });
    }

    function Actions()
    {
        return collect($this->action_list);
    }

    function isAction($action)
    {
        return collect($this->action_list)->contains($action);
    }
}
