<?php
namespace App\maguttiCms\Domain\Location;

use App\Location;

trait MapLocationPresenter

{
    /**
     *
     * map Info
     * popup window content
     *
     * @return string
     */
    function getMapInfo(){
        return  "<div class='mapPop'><h5>".stripslashes($this->title)."</h5>".$this->getDisplayBlockAttribute()."<br></div>";
    }

    /**
     *
     * left empty  for default marker "";
     *
     * @return string
     */
    function getMapMarker(){

        return  asset('website/images/map_marker.png');
    }
}
