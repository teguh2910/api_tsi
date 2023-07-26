<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\ChatRoomResource;
use App\Models\Chat;
use App\Models\ChatRoom;
use App\Models\Meeting;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    public function index()
    {
        $today = date('Y-m-d');
        $time   = time()-(45*60);
        $pasien_meeting   = Meeting::where([
            'attendee'      => Auth::id(),
            'date_start'    => $today,
            ])->where('time', ">", $time);
        $counselor_meeting = Meeting::where([
            'host'          => Auth::id(),
            'date_start'    => $today,
        ])->where('time', ">", $time);
        $counselor  = User::where('counselor', true)->where('_id', '!=', Auth::id());
        $users      = User::orderBy('nama.nama_depan')->get();
        $data = [
            "title"             => "Video Conference",
            "class"             => "Marital Status",
            "sub_class"         => "Get All",
            "content"           => "layout.admin",
            "pasien_meeting"    => $pasien_meeting->get(),
            "counselor"         => $counselor->get(),
            "user"              => Auth::user(),
            "counselor_meeting" => $counselor_meeting->get(),
            "users"             => $users
        ];

        return view('user.message.index', $data);
    }
    public function chat_room($id)
    {
        $my_id      = Auth::id();
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
        return view('user.message.show', $data);
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
        $session_token  = decrypt(session('web_token'));
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
        $user           = User::find($id);
        $session_token  = decrypt(session('web_token'));
        $client         = new Client();
        $url            = "https://dev.atm-sehat.com/api/v1/chatRoom/user?id_receiver=$id";
        $header         = [
            'Authorization' => "Bearer $session_token",
        ];
        $response = $client->get($url, [
            'headers' => $header
        ]);
        $statusCode = $response->getStatusCode();
        if ($statusCode == 200 or $statusCode == 201) {
            $chat_rooms1 = ChatRoom::where([
                'user1' => $id,
                'user2' => Auth::id()
            ]);
            $chat_rooms2 = ChatRoom::where([
                'user1' => Auth::id(),
                'user2' => $id
            ]);
//                dd($chat_rooms1->count());
            if($chat_rooms1->count() > 0 ){
                $chat_rooms = $chat_rooms1->first();
            }elseif($chat_rooms2->count() > 0 ){
                $chat_rooms = $chat_rooms2->first();
            }else{

            }
            return redirect()->route('message.room', ['id'=>$chat_rooms->_id]);
        } else {
            return "Gagal mengirim formulir: ";
        }
    }
}
