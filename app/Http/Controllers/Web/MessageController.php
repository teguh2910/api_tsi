<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\ChatRoomResource;
use App\Models\Chat;
use App\Models\ChatRoom;
use App\Models\User;

class MessageController extends Controller
{
    public function index()
    {
        $my_id      = "64ab60837fb2f5709001bbe2";
        $chat_roms  = ChatRoom::where([
            'user1' => $my_id
        ])->orWhere([
            'user2' => $my_id
        ]);
        $data_chat_room = ChatRoomResource::collection($chat_roms->get());
        $data = [
            "title"         => "Marital Status",
            "class"         => "Marital Status",
            "sub_class"     => "Get All",
            "content"       => "layout.admin",
        ];
        return view('admin.message.index', $data);
    }
    public function chat_room($id)
    {
        $my_id      = "64ab60837fb2f5709001bbe2";

        $chat_room  = ChatRoom::find($id);
        $chats      = Chat::where('id_chat_room', $id)->get();
        $data = [
            "title"         => "Marital Status",
            "class"         => "Marital Status",
            "sub_class"     => "Get All",
            "content"       => "layout.admin",
            "chat_room"     => $chat_room,
            "chats"         => $chats
        ];
        return view('admin.message.show', $data);
    }
}
