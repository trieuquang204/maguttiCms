<?php

namespace App\maguttiCms\Domain\Block\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BlockCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {


        return [
            'data' => BlockResource::collection($this),
            'links' => [
                'self' => 'link-value',
            ],
        ];
    }

}
