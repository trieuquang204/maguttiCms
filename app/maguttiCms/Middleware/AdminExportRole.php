<?php

namespace App\maguttiCms\Middleware;

use App\Tour;
use Closure;
// Add Response namespace
use Illuminate\Http\Response;

;

use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;

class AdminExportRole extends AdminRole
{
    public function canAccess()
    {

        if (auth_user('admin')->isAdim()) {
            return true;
        }
        /*$owner_id = get_shop_id_by_user();

        if ($this->model == 'users' or request()->has('tour_id') ) {
            if (request()->has('tour_id')) {
                $data = Tour::find(request()->get('tour_id'));
                return cmsUserIsOwner($data->shop_id, $owner_id);
            }
            return true;
        }*/
        return (!isset($this->config['roles']) || cmsUserHasRole($this->config['roles'])) ? true : false;
    }
}
