<?php namespace App\maguttiCms\Admin;
use Form;
use App;

use App\maguttiCms\Admin\Helpers\AdminFormRelation;

/**
 * Class AdminFormImageRelation
 * @package App\maguttiCms\Admin
 */
class AdminFormImageRelation  {

    use AdminFormRelation;
    protected  $property;
    protected  $a;
    protected  $field;
    protected  $image_field = "image";
    protected  $selectedItem;
    public function setProperty($property)
    {
        $this->property = $property;
        return $this;
    }

    public function get($field, $selItem = '') {
        $obj = $this->getRelation();
        $this->field = $field;
        $this->selectedItem = $selItem;
        $this->a  = ( isset( $this->property['foreign_key'] ) ) ? $this->property['foreign_key'] : 'id';
        $this->image_field = ( isset( $this->property['image_field']  )  ) ? $this->property['image_field'] : $this->image_field;

        $html = "<div class=\"row row-semi-condensed\">";
            $html .= "<input type=\"hidden\" value='". $this->selectedItem ."' name=\"". $this->field ."\" id=\"". $this->field ."\">";
            $html .= $this->getSelectedImage($obj);
            $html .= $this->getImageList($obj);
        $html .= "</div>";

        return  $html ;
    }


    protected function getSelectedImage($obj){
        $html = "";
        foreach( $obj as $item ) {
            if ($item->{$this->a} ==  $this->selectedItem ) $html .= $this->getHtmlImage($item,"active");
        }
        return $html;
    }

    protected function getImageList($obj){
        $html = "";
        foreach( $obj as $item ) {
            if ($item->{$this->a} !=    $this->selectedItem ) $html .= $this->getHtmlImage($item);
        }
        return $html;
    }

    protected function getHtmlImage($item,$class="inactive"){

        $relationModel   =  "App\\".$this->property['model'] ;
        $objMedia        = $relationModel::find($item->{$this->a});
        $html ="<div class=\"col-4 col-md-2\"><a href=\"#\"
                     data-image-relation=\"".$this->field."\"  data-image-id =\"".$item->{$this->a}."\" class=\"thumbnail ".$class."\">";
            $html .="<img src=\"".ma_get_image_from_repository($objMedia->image)."\" alt=\"".$item->title."\" class='img-fluid'>";
        $html .="</a></div>";
        return $html;
    }
}
