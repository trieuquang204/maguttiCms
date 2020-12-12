<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'date' => $this->date,
            'title' => $this->title,
            'description' => $this->description,
            'category' => data_get($this,'category.name'),
            'slug' => $this->slug,
            'image' => $this->image,
            'pub' => $this->pub,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
