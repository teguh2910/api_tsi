<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LinkedUserController extends Controller
{
    public function index(){
        $user       = User::where('family.id_induk', Auth::user()['_id']);
        $family     = UserResource::collection($user->get());
        if($user->count() < 1){
            $status_code = 404;
            $data   = [
                "status"        => "Not Found",
                "status_code"   => 404,
                "data"          => [
                    'count'     => $user->count(),
                    'family'    => $family,
                ]
            ];
            return response()->json($data,$status_code);
        }else{
            $status_code = 200;
            $data   = [
                "status"        => "success",
                "status_code"   => 200,
                "data"          => [
                    'count'     => $user->count(),
                    'family'    => $family,
                ]
            ];
            return response()->json($data,$status_code);
        }
    }
    public function store(Request $request){
        $validator              = Validator::make($request->all(), [
            'nama_depan'        => 'required',
            'nama_belakang'     => 'required',
            'tanggal_lahir'     => 'required',
            'tempat_lahir'      => 'required',
            'hubungan_keluarga' => 'required'
        ]);
        if ($validator->fails()){
            $status_code = 422;
            $data = [
                'status_code'   => $status_code,
                'message'       => 'Gagal Validasi',
                "data"          => [
                    "errors"     => $validator->errors(),
                ]
            ];
            return response()->json($data,$status_code);
        }else if($request->hubungan_keluarga != "Anak"){
            $status_code = 419;
            $data = [
                'status_code'   => $status_code,
                'message'       => 'Gagal Validasi',
                "data"          => [
                    "errors"     => [
                        'hubungan_keluarga' => ['Hubungan keluarga harus Anak']
                    ],
                ]
            ];
            return response()->json($data,$status_code);
        }else{
            $status_code=201;
            $nik_dummy  = random_int(111111111111,999999999999);
            $data_input = [
                "nama_depan"    => $request->nama_depan,
                "nama_belakang" => $request->nama_belakang,
                "nomor_telepon" => random_int(111111111111,999999999999),
                "gender"        => $request->gender,
                "nik"           => $nik_dummy,
                "password"      => "password",
                "tempat_lahir"  => $request->tempat_lahir,
                "tanggal_lahir" => $request->tanggal_lahir,
                "family"        => [
                    'id_induk'  => Auth::id(),
                    'hubungan_keluarga' => $request->hubungan_keluarga
                ]
            ];
            $add_data = $this->register($data_input);
            $add_family = User::where('nik', $nik_dummy)->first();
            return response($add_family);
        }



    }
    private function register($data){
        $body = json_encode($data);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://dev.atm-sehat.com/api/v1/auth/register',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $body,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return response($response);

    }
}
