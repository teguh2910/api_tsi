<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ConsultantController extends Controller
{
    public function index(){

    }
    public function store(Request $request){
        $validator              = Validator::make($request->all(), [
            'id_user'       => 'required',
            'id_profesi'    => '',
            'tarif'         => '',
            'expired_date'  => ''
        ]);
        $user = User::find($request->id_user);
        if ($validator->fails()){
            $status_code    = 422;
            $message        = "Gagal validasi";
            $data           = [
                "error"     => $validator->errors()
            ];

        }elseif (empty($user)){
            $status_code    = 404;
            $message        = "User Not Found";
            $data           = [
                "user"     => $user
            ];
        }else{
            $status_code    = 200;
            $message        = "Success";
            $data           = [
                "user"     => $user
            ];
        }
        return response()->json([
            'status_code'   => $status_code,
            'message'       => $message,
            'data'          => $data
        ],$status_code);
    }
    public function sms(){
        $token  = "b115db523542ddc9d9ccd345de753204";
        $to     = "081906011985";
        $msg    = "Hari ini apih sedang liburan ke semarang";
        $url    = "http://websms.co.id/api/smsgateway?token=$token&to=$to&msg=urlencode($msg)";

        $header = array(
            'Accept: application/json',
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        $result = curl_exec($ch);

        echo $result;
    }

}





