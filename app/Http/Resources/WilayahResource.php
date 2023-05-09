<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WilayahResource extends JsonResource
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
            'id'        => $this->_id,
            'code'      => $this->code,
            'nama'      => $this->nama,
            'wilayah'   => $this->wilayah
        ];
    }
}
