<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FamilyResource extends JsonResource
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
            'nama_depan'        => $this->nama['nama_depan'],
            'nama_belakang'     => $this->nama['nama_belakang'],
            'tanggal_lahir'     => $this->lahir['tanggal'],
            'tempat_lahir'      => $this->lahir['tempat'],
            'gender'            => $this->gender,
            'status'            => $this->family['is_active'],
        ];
    }
}
