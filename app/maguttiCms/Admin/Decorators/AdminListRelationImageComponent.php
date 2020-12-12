<?php

namespace App\maguttiCms\Admin\Decorators;

class AdminListRelationImageComponent extends AdminListImageComponent
{
    public function getValue()
    {
       return  $this->value =  (optional($this->item)->{$this->getItemProperty('relation')}) ? $this->item->{$this->getItemProperty('relation')}->{$this->getField()}:'';
    }

}
