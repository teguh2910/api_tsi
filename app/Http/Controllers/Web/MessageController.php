<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\ChatRoomResource;
use App\Models\Chat;
use App\Models\ChatRoom;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        if($chat_room->user1 == $my_id){
            $partner = User::find($chat_room->user2) ;
        }else{
            $partner = User::find($chat_room->user1);
        }
        $chats      = Chat::where('id_chat_room', $id)->get();
        $data = [
            "title"         => "Marital Status",
            "class"         => "Marital Status",
            "sub_class"     => "Get All",
            "content"       => "layout.admin",
            "chat_room"     => $chat_room,
            "chats"         => $chats,
            "my_id"         => $my_id,
            "partner"       => $partner

        ];
        return view('admin.message.show', $data);
    }
    public function store_chat(Request $request)
    {
        $chat_input = [
            'id_chat_room'  => $request->id_chat_room,
            'id_receiver'   => $request->id_receiver,
            'message'       => $request->message
        ];
        $json_chat_input    = json_encode($chat_input);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://dev.atm-sehat.com/api/v1/chats',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>$json_chat_input,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer 64ab62d159953fca6103a002|Vay5hQzTq8fPptJEdej0M5bBckzDlTe02nRjxDIL'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        if($response){

            return redirect("/message/$request->id_chat_room");
        }else{
//            echo $json_chat_input;
            return redirect("/message/$request->id_chat_room");
        }
    }
}
