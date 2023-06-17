<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\FamilyResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LinkedUserController extends Controller
{
    public function index(){
        $user       = User::where('family.id_induk', Auth::user()['_id'])->orderBy('lahir.tanggal', 'DESC');
        $family     = FamilyResource::collection($user->get());
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
    public function list_by_id(Request $request){
        $id_induk   = $request->id_induk;
        $user       = User::where('family.id_induk', $id_induk)->orderBy('lahir.tanggal', 'DESC');
        $family     = FamilyResource::collection($user->get());
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
            return response($add_data->getOriginalContent());
        }
    }
    public function linking(Request $request){
        $validator              = Validator::make($request->all(), [
            'id_user'   => 'required',
            'id_induk'  => 'required'
        ]);
        $user       = User::find($request->id_user);
        $user_induk = User::find($request->id_induk);
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
        }else if(! empty($user) AND ! empty($user_induk)){
            $family = [
                'family'    =>[
                    'id_induk'          => $request->id_induk,
                    'hubungan_keluarga' => 'Anak',
                    'is_active'         => true
                ]

            ];
            $linking = $user->update($family);
            $status_code = 200;
            $data = [
                'status_code'   => $status_code,
                'message'       => 'Success',
                "data"          => [
                    "linking"   => "Success"
                ]
            ];
            return response()->json($data,$status_code);
        }else{
            $status_code = 404;
            $data = [
                'status_code'   => $status_code,
                'message'       => 'Not Found',
                "data"          => [
                    "user"      => $user,
                ]
            ];
            return response()->json($data,$status_code);
        }
    }
    public function unlink(Request $request){
        $id_user    = $request->id_user;
        $user       = User::find($id_user);
        $unlink     = [
            "family"    => [
                "id_induk"  => $user->family['id_induk'],
                "hubungan_keluarga"  => $user->family['hubungan_keluarga'],
                "is_active" => false
            ]
        ];
        $update     = $user->update($unlink);
        $status_code = 200;
        $data = [
            'status_code'   => $status_code,
            'message'       => 'Success',
            "data"          => [
                "Unlink"     => "Success",
            ]
        ];
        return response()->json($data,$status_code);
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
