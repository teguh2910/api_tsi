<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\ChatRoom;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ChatController extends Controller
{
    public function index()
    {
        $chat_list = Chat::all();
        if($chat_list->count() > 0){
            $status_code    = 200;
            $message        = "success";
            $data           = [
                'count'     => $chat_list->count(),
                'chat'      => $chat_list
            ];

        }else{
            $status_code    = 404;
            $message        = "Not Found";
            $data           = [
                'count'     => $chat_list->count(),
                'chat'      => $chat_list
            ];
        }
        $respons = [
            'status_code'   => $status_code,
            'message'       => $message,
            'data'          => $data
        ];
        return response()->json($respons, $status_code);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id_chat_room'  => 'required',
            'id_receiver'   => 'required',
            'message'       => 'required',
            'read_at'       => 'date'
        ]);
        $data_input             = $validator->validated();
        $data_input['id_sender']= Auth::id();
        if ($validator->fails()) {
            $status_code    = 422;
            $message        = "Gagal Validasi";
            $data = [
                'errors' => $validator->errors(),
            ];
        }else{
            $chat_room  = ChatRoom::where('_id', $request->id_chat_room);
            if($chat_room->count() < 1 ){
                $status_code    = 404;
                $message        = "Wrong ID Chat Room";
                $data           = '';
            }else{
                $receiver   = User::find($request->id_receiver);
                if(empty($receiver)){
                    $status_code    = 404;
                    $message        = "receiver not found";
                    $data = '';
                }else{
                    $chat                   = new Chat();
                    $create                 = $chat->create($data_input);
                    if($create){
                        $status_code    = 200;
                        $message        = "success";
                        $data = [
                            'chat' => $data_input,
                        ];
                    }
                }
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
