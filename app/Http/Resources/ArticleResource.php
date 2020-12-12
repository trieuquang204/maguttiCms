<?php

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'parent_id' =>  $this->parent_id,
            'parent' => data_get($this,'parent.title'),
            'slug' => $this->slug,
            'image' => $this->image,
            'pub' => $this->pub,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

}
