<?php
/**
 * Created by PhpStorm.
 * User: web01
 * Date: 2019-10-15
 * Time: 09:09
 */

namespace App\maguttiCms\Admin\Decorators;


class AdminListUploadComponent extends AdminListComponent
{

   public  function render(){
       return $this->component();
   }

   protected function component(){
       if($this->getValue()=='') return "";
       $media = $this;
       return view('admin.list.document', compact('media'));
   }

}