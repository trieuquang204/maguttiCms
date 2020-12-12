<?php

namespace App\maguttiCms\Middleware;

use Closure;
// Add Response namespace
use Illuminate\Http\Response;;

use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;

class AdminEditRole extends AdminRole
{
    public  function canAccess(){

        if(cmsUserHasRole('su')) return  true;
        if($this->model=='adminusers'){
            return ( cmsUserIsOwner($this->model_id,auth_user('admin')->id ) ) ? true : false;
        }
        else {
            $model    = new  $this->modelClass;
            $data     = $model->find($this->model_id);
            if($this->model=='media'){
                /* TODO*/
                //return ( cmsUserIsOwner($data->model->shop_id, $owner_id) ) ? true : dd('error');
            }
        }
        return (!isset($this->config['roles']) || cmsUserHasRole($this->config['roles']))?true:false;
    }
}
