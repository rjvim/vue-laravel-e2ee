<?php

namespace App\Http\Resources;

use Illuminate\Support\Arr;

use Illuminate\Http\Resources\Json\JsonResource;

class Note extends JsonResource
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
            'content' => $this->content,
            'access' => $this->users()->select('email', 'role')->get()
        ];


        return parent::toArray($request);
    }
}
