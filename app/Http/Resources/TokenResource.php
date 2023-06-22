<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TokenResource extends JsonResource
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
            'id'            => $this->_id,
            'name'          => $this->name,
            'created_at'    => $this->created_at,
            'last_used'     => $this->updated_at,
            'expires_at'    => $this->expires_at
        ];
    }
}
