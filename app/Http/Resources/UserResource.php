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
            'nama_depen'        => $this->nama['nama_depan'],
            'nama_belakang'     => $this->nama['nama_belakang'],
            'tanggal_lahir'     => $this->lahir['tanggal'],
            'tempat_lahir'      => $this->lahir['tempat'],
            'gender'            => $this->gender,
            'nik'               => $this->nik,
            'email'             => $this->kontak['email'],
            'nomor_telepon'     => $this->kontak['nomor_telepon'],
            'username'          => $this->username,
            'address'           => $this->address,
            'pemeriksaan_kesehatan'   => $this->pemeriksaan_kesehatan,
        ];
    }
}
