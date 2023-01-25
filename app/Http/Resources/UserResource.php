<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'id'                => $this->_id,
            'nama'              => $this->nama,
            'lahir'             => $this->lahir,
            'gender'            => $this->gender,
            'nik'               => $this->nik,
            'kontak'            => $this->kontak,
            'username'          => $this->username,
            'address'           => $this->address,
            'health_overview'   => $this->health_overview,
        ];
    }
}
