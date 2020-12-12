<?php
/**
 * Created by PhpStorm.
 * User: web01
 * Date: 2019-10-15
 * Time: 09:09
 */

namespace App\maguttiCms\Admin\Decorators;


use Carbon\Carbon;

class  AdminListLocaleComponent extends AdminListComponent
{

    public function render()
    {
        $value = $this->getValue();
        return "<img class=\"flag\" 
                     src=\"" . asset(config('maguttiCms.admin.path.assets')."website/images/flags/" . $value . ".png") . "\" 
                     alt=\"" . $value . " flag\">";
    }
}

