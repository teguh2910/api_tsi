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
            'id'            => $this->_id,
            'id_pasien'     => $this->id_pasien,
            'pasien'        => $this->pasien,
            'id_petugas'    => $this->id_petugas,
            'atm_sehat'     => $this->atm_sehat,
            'coding'        => $this->coding,
            'time'          => $this->time,
            'hasil'         => [
                'value'     => round($this->value,2),
                'unit'      => $this->unit
            ],
            'base_line'     => $this->base_line,
            'interpretation'=> $this->interpretation,

        ];
    }
}
