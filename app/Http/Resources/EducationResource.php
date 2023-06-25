<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EducationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
//        return parent::toArray($request);
        return [
            'id'            => $this->id,
            'grade'         => $this->grade,
            'kode'          => $this->kode,
            'pendidikan'    => $this->pendidikan,
            'level'         => $this->level,
            'jenis'         => $this->jenis
        ];
    }
}
