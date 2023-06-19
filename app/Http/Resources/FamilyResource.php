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
        $birthDate          = new \DateTime($this->lahir['tanggal']);
        $today              = new \DateTime("today");
        $y                  = $today->diff($birthDate)->y;
        $m                  = $today->diff($birthDate)->m;
        $d                  = $today->diff($birthDate)->d;
        $usia               = [
            'tahun'         => $y,
            'bulan'         => $m,
            'hari'          => $d
        ];
        return [
            'id'                => $this->_id,
            'nama_depan'        => $this->nama['nama_depan'],
            'nama_belakang'     => $this->nama['nama_belakang'],
            'tanggal_lahir'     => $this->lahir['tanggal'],
            'tempat_lahir'      => $this->lahir['tempat'],
            'gender'            => $this->gender,
            'hubungan_keluarga' => $this->family['hubungan_keluarga'],
            'status'            => $this->family['is_active'],
            'usia'              => $usia
        ];
    }
}
