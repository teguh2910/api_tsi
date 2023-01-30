<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChatController extends Controller
{
    public function index()
    {
        $chat_list = Chat::all();
        if(!empty($chat_list)){
            return response()->json([
                'status_code'   => 200,
                'message'       => 'success',
                'content'       => $chat_list
            ]);
        }
        return response()->json([
            'status_code'   => 404,
            'message'       => 'Not Found'
        ]);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
           'id_consultan'   => ''
        ]);
    }
}
