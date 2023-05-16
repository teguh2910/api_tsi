<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Kit;
use App\Models\Log_user_kit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LogUserKitController extends Controller
{
    public function index(){

    }
    public function show($code){

    }
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'id_atm_sehat_kit'  => 'required',
        ]);
        $id_atm_sehat_kit   = $request->id_atm_sehat_kit;
        $kit                = Kit::where('code',$id_atm_sehat_kit)->first();
        if($validator->fails()){
            $status_code    = 422;
            $data           = [
                "status_code"   => $status_code,
                "message"       => "gagal Validasi",
                "data"          => [
                    "errors"    => $validator->errors()
                ]
            ];
            return response()->json($data, $status_code);
        }else if(empty($kit)){
            $status_code    = 404;
            $data           = [
                "status_code"   => $status_code,
                "message"       => "Not Found",
                "data"          => [
                    "kits"    => $kit
                ]
            ];
            return response()->json($data, $status_code);
        }else{
            $data_kit       = [
                'kit_code'      => $kit->code,
                'nik_petugas'   => $kit->operator['nik'],
                'time'          => time(),
                'id_pasien'     => Auth()->id()

            ];
            $log_user_kit   = new Log_user_kit();
            $add            = $log_user_kit->create($data_kit);
        }
    }
}
