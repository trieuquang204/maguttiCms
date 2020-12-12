<?php

namespace App\maguttiCms\Admin\Decorators\AdminForm;

use App\Media;
use Form;

/**
 * Class MediaComponent
 * @package App\maguttiCms\Admin\Decorators\AdminForm
 */
class FileManagerComponent extends ViewComponent
{


    function resolveViewName()
    {
       return  $this->viewName = 'admin.inputs.container_manager';
    }

    function viewBag()
    {
        $this->viewBag = parent::viewBag();
        $media = Media::where('id', $this->value)->first();
        $this->addItemToBag('media',$media);
        return $this->viewBag;
    }

}