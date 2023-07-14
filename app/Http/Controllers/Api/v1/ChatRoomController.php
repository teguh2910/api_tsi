<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ChatRoomResource;
use App\Models\Chat;
use App\Models\ChatRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ChatRoomController extends Controller
{
    public function index()
    {
        $chat_rooms = ChatRoom::all();
        if($chat_rooms->count() < 1){
            $status_code    = 404;
            $message        = "Not Found";
            $data = [
                'count'     => $chat_rooms->count(),
                'chat_rooms' => ChatRoomResource::collection($chat_rooms),
            ];
        }else{
            $status_code    = 200;
            $message        = "success";
            $data = [
                'count'     => $chat_rooms->count(),
                'chat_rooms' => ChatRoomResource::collection($chat_rooms),
            ];
        }
        $respons = [
            'status_code'   => $status_code,
            'message'       => $message,
            'data'          => $data
        ];
        return response()->json($respons, $status_code);
    }
    public function user(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id_receiver' => 'required',
        ]);
        if ($validator->fails()) {
            $status_code    = 422;
            $message        = "Gagal Validasi";
            $data = [
                'errors' => $validator->errors(),
            ];
        }else{
            $sending_chat       = Chat::where([
                'id_receiver'   => $request->id_receiver,
                'id_sender'     => Auth::id()
            ]);
            $received_chat       = Chat::where([
                'id_receiver'   => Auth::id(),
                'id_sender'     => $request->id_receiver
            ]);
            $chat       = Chat::where([
                'id_receiver'   => $request->id_receiver,
                'id_sender'     => Auth::id()
            ])->orWhere([
                'id_receiver'   => Auth::id(),
                'id_sender'     => $request->id_receiver
                ])->get();
            $chat_rooms = ChatRoom::where([
                'user1' => $request->id_receiver,
                'user2' => Auth::id()
            ])->orWhere([
                'user2' => $request->id_receiver,
                'user1' => Auth::id()
            ]);
            if($chat_rooms->count() < 1){
                $this->store(Auth::id(), $request->id_receiver);
                $status_code    = 200;
                $message        = "chat room created";
                $data = [
                    'count'     => $chat_rooms->count(),
                    'chat_rooms' => $chat_rooms,
                ];
            }else{
                $status_code    = 200;
                $message        = "success";
                $data = [
                    'sending_chat'  => $sending_chat->count(),
                    'receive_chat'  => $received_chat->count(),
                    'chat_rooms'    => $chat_rooms->first(),
                    'chat'          => $chat
                ];
            }
        }
        $respons = [
            'status_code'   => $status_code,
            'message'       => $message,
            'data'          => $data
        ];
        return response()->json($respons, $status_code);
    }
    private function store($id_user1, $id_user2,$group=null)
    {
        $chat_room      = new ChatRoom();
        $data_chat_room = [
            'user1'     => $id_user1,
            'user2'     => $id_user2,
            'is_group'  => $group
        ];
        $create         = $chat_room->create($data_chat_room);
        if($create){
            return response($create);
        }
    }
    public function show(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id_chat_room' => 'required',
        ]);
        if ($validator->fails()) {
            $status_code    = 422;
            $message        = "Gagal Validasi";
            $data = [
                'errors' => $validator->errors(),
            ];
        }else{
            $chat_room  = ChatRoom::where('_id',$request->id_chat_room);
            $chat       = Chat::where('id_chat_room', $request->id_chat_room);
            if($chat_room->count() < 1 ){
                $status_code    = 404;
                $message        = "Wrong ID Chat Room";
                $data           = "";
            }else{
                $status_code    = 200;
                $message        = "success";
                $data           = [
                    'chat_room' => $chat_room->first(),
                    'chat'      => $chat->get(),
                ];
            }
        }
        $respons = [
            'status_code'   => $status_code,
            'message'       => $message,
            'data'          => $data
        ];
        return response()->json($respons, $status_code);
    }
}
