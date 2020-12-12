<?php

namespace App\maguttiCms\Middleware;

use Closure;
// Add Response namespace
use Illuminate\Http\Response;;

use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
/* TODO to be implemented */
class AdminStoreRole extends AdminRole
{
    public  function canAccess(){

        if(cmsUserHasRole('su')) return  true;
        if($this->model=='adminusers'){
            return ( cmsUserIsOwner($this->model_id,auth_user('admin')->id ) ) ? true : false;
        }
        else {

        }
        return (!isset($this->config['roles']) || cmsUserHasRole($this->config['roles']))?true:false;
    }
}
