<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MapLocationResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function toArray($request)
    {
        JsonResource::withoutWrapping();
        return [

             $this->title,
             $this->lat,
             $this->lng,
             '',//$this->getMapMarker(), custom marker
             $this->getMapInfo()
        ];
    }
}
