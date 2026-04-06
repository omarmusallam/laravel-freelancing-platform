<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'category' => new CategoryResource($this->category),
            'user' => [
                'id' => $this->user_id,
                'name' => optional($this->user)->name,
            ],
            'title' => $this->title,
            'description' => $this->desc,
            'type' => $this->type,
            'budget' => $this->budget,
            'update_time' => $this->updated_at,
            'status' => $this->status,
            'tags' => TagResource::collection($this->tags),
            '_links' => [
                '_self' => url('api/projects/' . $this->id),
            ],
        ];
    }
}
