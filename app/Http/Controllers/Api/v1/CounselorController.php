<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CounselorResource;
use App\Models\User;
use Illuminate\Http\Request;

class CounselorController extends Controller
{
    public function index()
    {
        $counselor = User::where('counselor', true)->get();
        $data_counselor = CounselorResource::collection($counselor);
        if($counselor->count() < 1){
            $status_code    = 404;
            $message        = "Not Found";
            $data           = [
                'counselor' => $counselor
            ];
        }else{
            $status_code    = 200;
            $message        = "success";
            $data           = [
                'count'     => $counselor->count(),
                'counselor' => $data_counselor
            ];
        }
        $response = [
            'status_code'   => $status_code,
            'message'       => $message,
            'data'          => $data
        ];
        return response($response, $status_code);
    }
    public function store(Request $request)
    {
        $id_user    = $request->id_user;
        $user       = User::where('_id', $id_user);
        if($user->count() < 1 ){
            $status_code    = 404;
            $message        = "Not Found";
            $data           = [
                'count'     => $user,
                'counselor' => $user->first()
            ];
        }else{
            $user->update([
                'counselor' => true
            ]);
            $status_code    = 200;
            $message        = "success";
            $data           = [
                'count'     => $user,
                'counselor' => $user->first()
            ];
        }
        $response = [
            'status_code'   => $status_code,
            'message'       => $message,
            'data'          => $data
        ];
        return response($response, $status_code);
    }
    private function curl()
    {

    }

}
