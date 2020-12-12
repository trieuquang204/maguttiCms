<?php
/**
 * Created by PhpStorm.
 * User: web01
 * Date: 2019-10-15
 * Time: 09:09
 */

namespace App\maguttiCms\Admin\Decorators;

class AdminListImageComponent extends AdminListComponent
{
    protected $image;
    protected $thumb;
    protected $disk;
    protected $folder;

    public  function render(){
       return $this->component();
   }

   protected function component(){
       if($this->getValue()=='') return "";

       $media = $this;
       return view('admin.list.image', compact('media'));
   }

    /**
     * @return mixed
     */
    public function getDisk()
    {
        return $this->getFieldSpecProperty('disk');
    }

    /**
     * @return mixed
     */
    public function getFolder()
    {
        return $this->getFieldSpecProperty('folder');
    }

}