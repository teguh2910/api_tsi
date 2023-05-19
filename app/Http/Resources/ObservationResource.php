<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ObservationResource extends JsonResource
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
            'id_pasien'     => $this->id_pasien,
            'id_petugas'    => $this->id_petugas,
            'atm_sehat'     => [
                'code'      => $this->atm_sehat['code_kit']
            ],
            'coding'        => $this->coding,
            'time'          => $this->time,
            'hasil'         => [
                'value'     => $this->value,
                'unit'      => $this->unit
            ],
            'base_line'     => $this->baseline,
            'interpretation'=> $this->interpretation,
        ];
    }
}
