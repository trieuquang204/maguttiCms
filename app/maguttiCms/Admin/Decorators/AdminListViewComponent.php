<?php
/**
 * Created by PhpStorm.
 * User: web01
 * Date: 2019-10-15
 * Time: 09:09
 */

namespace App\maguttiCms\Admin\Decorators;


/**
 * Simple  class to render generic view list component
 *
 * Class AdminListViewComponent
 * @package App\maguttiCms\Admin\Decorators
 */
class  AdminListViewComponent extends AdminListComponent
{

    public  function render(){
        return $this->component();
    }

}