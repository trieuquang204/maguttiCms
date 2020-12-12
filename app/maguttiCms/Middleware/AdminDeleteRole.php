<?php

namespace App\maguttiCms\Middleware;
/* TODO to be implemented */
class AdminDeleteRole extends AdminRole
{
    public  function canDelete(){
        return  $this->canAccess();
    }
}