<?php

namespace App\maguttiCms\Domain\Admin;

use App\Role;
use Illuminate\Support\Facades\Auth;
use App\AdminUser;


/*
|--------------------------------------------------------------------------
| SIMPLE ACL ROLE
|--------------------------------------------------------------------------
|
*/
/**
 *
 * Trait AdminAcl
 * @package App\maguttiCms\Domain\Admin
 */
trait AdminAcl
{


    /**
     * @param $section
     * @return bool
     */
    public function canViewSection($section)
    {
        if (!isset($section['roles'])) {
            return true;
        }
        if ($this->hasRole($section['roles'])) {
            return true;
        } else {
            return false;
        }
    }

    /**
     *
     * @return int
     */
    public function isSu()
    {
        return Auth::guard('admin')->user()->hasRole(['su']);
    }

    /**
     * GF_ma utenti con ruolo
     * su or  admin
     * @return int
     */
    public function isAdmin()
    {
        return Auth::guard('admin')->user()->hasRole(['su', 'admin']);
    }


    /**
     *
     * GF_ma semplice gestione assegnazione ruoli
     * solo admin e su possono asegnare
     * i ruoli agli utenti del cms
     * @return int
     */
    public function hideEditRole()
    {
        return !$this->isAdmin();
    }

    /**
     *
     * GF_ma gestione funzionalità
     * di delete per ruolo
     * @return int
     */
    public function canDelete()
    {
        return Auth::guard('admin')->user()->hasRole(['su', 'admin']);
    }

    /**
     * GF_ma gestione semplice delle sezioni
     * in base hai ruoli
     * @param $section
     * @return bool
     */
    public function roleFilter()
    {
        if (request()->has('type')) return ' name = "user" ';
        return ($this->isSu()) ? '' : 'name != "su"';
    }

    public function action($action, $action_property)
    {


        $value = $this->actionValue($action_property, $action);

        if (!$value) return false;
        if ($this->isSu()) return true;
        if (!is_array($value)) return $value;
        if (data_get($value, 'roles')) {
            return cmsUserHasRole($value);
        }
        if (data_get($value, 'action')) {
            $method = data_get($value, 'action');
            if (method_exists($this, $action . ucfirst($method))) {
                return $this->{$action . ucfirst($method)}();
            }
        }
        return false;
    }

    function actionValue($action_property, $action)
    {

        return data_get($action_property['actions'], $action);
    }


    function userHasPersmission($section)
    {
        $permitted_section = ['Tour', 'User'];
        if ($section['model'] == 'Document') {
            return $this->has_documents;
        } elseif ($this->shop && $this->shop->hasActiveParentShop()) {
            if ($section['model'] == 'Purchase' && $this->is_business == 1) {
                return true;
            } else {
                if ($this->hasRole($section['roles']) && in_array($section['model'], $permitted_section)) {
                    return true;
                } elseif ($this->hasRole($section['roles']) && $section['model'] == 'Shop' && $this->shop->show_content) {
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            return $this->hasRole($section['roles']);
        }
    }
}