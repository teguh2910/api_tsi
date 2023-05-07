<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SystoleResource extends JsonResource
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
            'id_pasien'     => $this->id_pasien,
            'id_petugas'    => $this->id_petugas,
            'coding'        => $this->coding,
            'time'          => $this->time,
            'hasil'         => [
                'value'     => $this->value,
                'unit'      => $this->unit
            ]
        ];
    }
}
