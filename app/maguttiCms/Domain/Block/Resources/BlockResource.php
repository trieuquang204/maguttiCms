<?php

 namespace App\maguttiCms\Domain\Block\Resources;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\JsonResource;

class BlockResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $attributes= parent::attributesToArray($request);
        $attributes['image_url'] = optional($this->imageMedia)->getPreviewThumbAttribute();
        return array_merge($attributes,$this->translatables);
    }
}
