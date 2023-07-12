<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource
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
            'key'       => $this->_id,
            'name'      => $this->name,
            'extention' => $this->extention,
            'mimeType'  => $this->mimeType,
            'size'      => $this->size,
            'user_id'   => $this->user_id
        ];
    }
}
