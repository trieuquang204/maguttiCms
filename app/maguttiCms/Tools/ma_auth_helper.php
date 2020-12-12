<?php


/*
|--------------------------------------------------------------------------
|  Admin role helper
|--------------------------------------------------------------------------
*/
//This method is used to check the admin role
function cmsUserHasRole($role)
{
    return (auth_user('admin')->hasRole($role)) ? 1 : 0;
}

function cmsUserIsOwner($model_id, $user_id)
{
    return (cmsUserHasRole(['su', 'admin']) || $model_id == $user_id) ? 1 : 0;
}

// current_auth_user
function auth_user($guard = '')
{
    return ($guard != '') ? auth($guard)->user() : auth()->user();
}

function cmsUserValidateRoles($data)
{
    return (data_get($data, 'roles', false) == false) ? true : cmsUserHasRole($data['roles']);
}


function cmsUserValidateActionRoles($action_list){
    return $authorized_action = collect($action_list)->filter(function ($_item, $key) {
        return ((cmsUserValidateRoles($_item)))?$_item:'';
    });
}



