<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\ChatRoomResource;
use App\Models\Chat;
use App\Models\ChatRoom;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $id_chat_room = $request->id_chat_room;
        $chat_input = [
            'id_chat_room'  => $request->id_chat_room,
            'id_receiver'   => $request->id_receiver,
            'message'       => $request->message
        ];
        $json_chat_input    = json_encode($chat_input);
        $body       = $json_chat_input;
        $url        = "https://dev.atm-sehat.com/api/v1/chats";
        $method     = "POST";
        $client = new Client();
        $session        = json_decode(decrypt(session('body')));
//        dd($session);
        $session_token  = $session->token->code;

        $response = $client->post($url, [
            'headers' => [
                'Authorization' => 'Bearer '.$session_token,
            ],
            'form_params' => $chat_input
        ]);
        $statusCode = $response->getStatusCode();
        $body = $response->getBody()->getContents();
        $tujuan ="message/$request->id_chat_room";
        if ($statusCode == 200) {
            return redirect()->route('message.room',['id'=>$id_chat_room]);
        } else {
            // Error
            return "Gagal mengirim formulir: " . $body;
        }
    }
    public function user($id)
    {
        $user = User::find($id);
        $chat_rooms = ChatRoom::where([
            'user1' => $id,
            'user2' => Auth::id()
        ])->orWhere([
            'user2' => $id,
            'user1' => Auth::id()
        ]);
        $session        = json_decode(decrypt(session('body')));
//        dd($session);
        $session_token  = $session->token->code;

        $client = new Client();
        $url    = "https://dev.atm-sehat.com/api/v1/chatRoom/user?id_receiver=$id";
        $header = [
            'Authorization' => "Bearer $session_token",
        ];
        $response = $client->get($url, [
            'headers' => $header
        ]);
        $statusCode = $response->getStatusCode();
        if ($statusCode == 200) {
            return redirect()->route('message.room', ['id'=>$chat_rooms->first()->_id]);
        } else {
            return "Gagal mengirim formulir: ";
        }
    }
}
