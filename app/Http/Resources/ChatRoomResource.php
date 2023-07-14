<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatRoomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $user1      = User::find($this->user1)->first();
        $data_user1 = [
            'id'        => $user1->_id,
            'name'      => $user1->nama,
            'contact'   => $user1->kontak
        ];
        $user2      = User::find($this->user2)->first();
        $data_user2 = [
            'id'        => $user2->_id,
            'name'      => $user2->nama,
            'contact'   => $user2->kontak
        ];
        return [
            'id'        => $this->_id,
            'user1'     => $data_user1,
            'user2'     => $data_user2,
            'is_group'  => $this->is_group
        ];
    }
}
