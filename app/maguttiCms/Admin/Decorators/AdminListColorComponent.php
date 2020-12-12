<?php
/**
 * Created by PhpStorm.
 * User: web01
 * Date: 2019-10-15
 * Time: 09:09
 */

namespace App\maguttiCms\Admin\Decorators;


use Carbon\Carbon;

class  AdminListColorComponent extends AdminListComponent
{

    public function render()
    {
        return "<div class=\"color\" style=\"background-color:" . $this->getValue() . "\"></div>";
    }
}

