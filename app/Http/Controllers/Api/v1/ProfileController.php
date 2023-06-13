<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ObservationResource;
use App\Models\Observation;
use App\Models\User;
use App\Models\Wilayah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{

    public function index()
    {
        if(isset(Auth::user()['status_menikah'])){
            $status_nikah = Auth::user()['status_menikah']['display'];
        }else{
            $status_nikah   = "";
        }

        $data_user = [
            'id'            => Auth::id(),
            'nama_depan'    => Auth::user()['nama']['nama_depan'],
            'nama_belakang' => Auth::user()['nama']['nama_belakang'],
            'gender'        => Auth::user()['gender'],
            'lahir'         => Auth::user()['lahir'],
            'username'      => Auth::user()['username'],
            'nik'           => Auth::user()['nik'],
            'email'         => Auth::user()['kontak']['email'],
            'nomor_telepon' => Auth::user()['kontak']['nomor_telepon'],
            'status_pernikahan' => $status_nikah,
            'kit'               => Auth::user()['kit'],
            'alamat'        => [
                'provinsi'  => [
                    'id_provinsi'   => Auth::user()['address']['provinsi']['id_provinsi'],
                    'nama_provinsi' => Auth::user()['address']['provinsi']['nama_provinsi']
                ],
                'kota'      => [
                    'id_kota'   => Auth::user()['address']['kota']['id_kota'],
                    'nama_kota' => Auth::user()['address']['kota']['nama_kota'],
                ],
                'kecamatan' => [
                    'id_kecamatan'  => Auth::user()['address']['kecamatan']['id_kecamatan'],

                    'nama_kecamatan'=> Auth::user()['address']['kecamatan']['nama_kecamatan'],
                ],
                'kelurahan' => [
                    'id_kelurahan'      => Auth::user()['address']['kelurahan']['id_kelurahan'],
                    'nama_kelurahan'    => Auth::user()['address']['kelurahan']['nama_kelurahan'],
                ],
            ]
        ];
        return response()->json([
            'status_code'       => 200,
            'message'           => 'success',
            'content'           => $data_user
        ]);
    }
    public function update_username(Request $request)
    {
        $user       = Auth::user();
        $time       = time();
        $user['update_username'] = [
            'username'  => $request->username,
            'otp'       => rand(1000,9999),
            'created_at'=> $time,
            'exp'       => $time+(5*60),
        ];
        if(Auth::user()['update_username']['exp'] > $time){
            return response()->json([
                'status_code'   => 401,
                'message'       => 'Gagal request',
                'waiting'       => date('Y-m-d H:i:s', Auth::user()['update_username']['exp']),
            ],200);
        }
        $update     = $user->update();
        if($update){
            return response()->json([
                'status_code'   => 200,
                'message'       => 'success'
            ]);
        }
    }
    public function approve_username(Request $request)
    {
        $user       = Auth::user();
        $validator  = Validator::make($request->all(), [
            'otp'   => 'required',
        ]);
        if($request->otp != $user->update_password['otp']){

        }
    }
    public function update_alamat(Request $request)
    {
        $user = Auth::user();
        $validator      = Validator::make($request->all(), [
            'id_provinsi'   => 'required|numeric|digits:2',
            'id_kota'       => 'required|numeric|digits:4',
            'id_kecamatan'  => 'required|numeric|digits:6',
            'id_kelurahan'  => 'required|numeric|digits:10',
            'jalan'         => 'required',
            'rukun_warga'   => 'required|digits:3',
            'rukun_tetangga'=> 'required|digits:3'

        ]);
        if($validator->fails()){
            return response()->json([
                'status_code'   => 422,
                'message'       => 'gagal validasi',
                'data'          => [
                    'errors' => $validator->errors()
                ]
            ],422);
        }
        $provinsi   = Wilayah::where('code',(string) $request->id_provinsi)->first();
        $kota       = Wilayah::where('code',(string) $request->id_kota)->first();
        $kecamatan  = Wilayah::where('code',(string) $request->id_kecamatan)->first();
        $kelurahan  = Wilayah::where('code',(string) $request->id_kelurahan)->first();
        $alamat     = [
            'address'    =>[
                'provinsi'  => [
                    'id_provinsi'   => $provinsi->code,
                    'nama_provinsi' => $provinsi->nama
                ],
                'kota'      => [
                    'id_kota'       => $kota->code,
                    'nama_kota'     => $kota->nama
                ],
                'kecamatan' => [
                    'id_kecamatan'  => $kecamatan->code,
                    'nama_kecamatan'=> $kecamatan->nama
                ],
                'kelurahan' => [
                    'id_kelurahan'      => $kelurahan->code,
                    'nama_kelurahan'    => $kelurahan->nama,
                ],
                'kode_pos'      => $request->kode_pos,
                'rukun_warga'   => $request->rukun_warga,
                'rukun_tetangga'=> $request->rukun_tetangga,
                'jalan'         => $request->jalan,
                'nomor_rumah'   => $request->nomor_rumah

            ]

        ];
        $user = Auth::user();
        $update_alamat = $user->update($alamat);
        if($update_alamat){
            return response()->json([
                'status_code'   => 200,
                'message'       => 'success',
                'data'          => $alamat
            ],200);
        }
        return response()->json([
            'status_code'   => 401,
            'message'       => 'Gagal Update',
            'data'          => [
                'alamat'    => $alamat
            ]
        ],401);
    }
    public function update_identitas(Request $request)
    {
        $user           = Auth::user();
        $validator      = Validator::make($request->all(), [
            'nik'       => 'required|numeric'
        ]);
        if($validator->fails()){
            return response()->json([
                'status_code'   => 422,
                'message'       => 'gagal validasi',
                'data'          => [
                    'errors' => $validator->errors()
                ]
            ],422);
        }
        $update_profile = $user->update($request->all());

    }
    public function resume(){
        $tanggal_lahir = Auth::user()['lahir']['tanggal'];
        $birthDate = new \DateTime($tanggal_lahir);
        $today  = new \DateTime("today");
        $y      = $today->diff($birthDate)->y;
        $m      = $today->diff($birthDate)->m;
        $d      = $today->diff($birthDate)->d;
        $usia   = [
            'tahun'         => $y,
            'bulan'         => $m,
            'hari'          => $d
        ];
        $code_sistole   = "8480-6";
        $code_diastolic = "8462-4";
        $hr_code        = "8867-4";
        $body_temp_code = "8310-5";
        $body_weight_code   = "29463-7";
        $code_height    = "8302-2";
        $code_spo2      = "59408-5";
        $code_glucose   = "2345-7";
        $code_chole     = "2093-3";
        $code_UA        = "3084-1";
        $bmi_code       = "39156-5";
        return response()->json([
            'status_code'   => 200,
            'message'       => 'success',
            'data'          => [
                'today'             => $today,
                'gender'            => Auth::user()['gender'],
                'usia'              => $usia,
                'systole'           => $this->myObservation($code_sistole, 1)->original,
                'diastole'          => $this->myObservation($code_diastolic, 1)->original,
                'hearth_rate'       => $this->myObservation($hr_code, 1)->original,
                'body_temperature'  => $this->myObservation($body_temp_code, 1)->original,
                'body_weight'       => $this->myObservation($body_weight_code, 1)->original,
                'body_height'       => $this->myObservation($code_height, 1)->original,
                'oxygen_saturation' => $this->myObservation($code_spo2, 1)->original,
                'blood_glucose'     => $this->myObservation($code_glucose, 1)->original,
                'blood_cholesterole'=> $this->myObservation($code_chole, 1)->original,
                'uric_acid'         => $this->myObservation($code_UA, 1)->original,
                'bmi'               => $this->myObservation($bmi_code, 1)->original
            ]
        ]);
    }
    public function systole(Request $request){
        $limit          = $request->limit;
        $code_sistole   = "8480-6";
        $systole        = $this->myObservation($code_sistole, $limit);
        return response()->json([
            'status_code'   => 200,
            'message'       => 'success',
            'data'          => [
                'systole'   => $systole->original
            ]
        ],200);
    }
    public function diastole(Request $request){
        $limit          = $request->limit;
        $code_diastolic = "8462-4";
        $diastole       = $this->myObservation($code_diastolic, $limit);
        return response()->json([
            'status_code'   => 200,
            'message'       => 'success',
            'data'          => [
                'diastole'   => $diastole->original
            ]
        ],200);
    }
    public function hearth_rate(Request $request){
        $limit          = $request->limit;
        $code_HR        = '8867-4';
        $hearth_rate    = $this->myObservation($code_HR, $limit);
        return response()->json([
            'status_code'   => 200,
            'message'       => 'success',
            'data'          => [
                'hearth_rate'   => $hearth_rate->original
            ]
        ],200);
    }
    public function temperature(Request $request){
        $limit          = $request->limit;
        $code_suhu      = (string) '8310-5';
        $temperature    = $this->myObservation($code_suhu, $limit);
        return response()->json([
            'status_code'   => 200,
            'message'       => 'success',
            'data'          => [
                'temperature'   => $temperature->original
            ]
        ],200);
    }
    public function spo2(Request $request){
        $limit          = $request->limit;
        $code_spo2      = "59408-5";
        $spo2           = $this->myObservation($code_spo2, $limit);
        return response()->json([
            'status_code'   => 200,
            'message'       => 'success',
            'data'          => [
                'spo2'   => $spo2->original
            ]
        ],200);
    }
    public function weight(Request $request){
        $limit          = $request->limit;
        $weight_code    = "29463-7";
        $weight           = $this->myObservation($weight_code, $limit);
        return response()->json([
            'status_code'   => 200,
            'message'       => 'success',
            'data'          => [
                'weight'   => $weight->original
            ]
        ],200);
    }
    public function height(Request $request){
        $limit          = $request->limit;
        $code_height    = "8302-2";
        $height         = $this->myObservation($code_height, $limit);
        return response()->json([
            'status_code'   => 200,
            'message'       => 'success',
            'data'          => [
                'height'   => $height->original
            ]
        ],200);
    }
    public function bmi(Request $request){
        $limit          = $request->limit;
        $code_bmi       = "39156-5";
        $height         = $this->myObservation($code_bmi, $limit);
        return response()->json([
            'status_code'   => 200,
            'message'       => 'success',
            'data'          => [
                'bmi'   => $height->original
            ]
        ],200);
    }
    public function cholesterol(Request $request){
        $limit          = $request->limit;
        $code_chole     = "2093-3";
        $cholesterol    = $this->myObservation($code_chole, $limit);
        return response()->json([
            'status_code'   => 200,
            'message'       => 'success',
            'data'          => [
                'cholesterol '   => $cholesterol ->original
            ]
        ],200);
    }
    public function uric_acid(Request $request){
        $limit              = $request->limit;
        $observation_code   = "3084-1";
        $observation        = $this->myObservation($observation_code, $limit);
        return response()->json([
            'status_code'   => 200,
            'message'       => 'success',
            'data'          => [
                'uric_acid'   => $observation->original
            ]
        ],200);
    }
    public function glucose(Request $request){
        $limit              = $request->limit;
        $observation_code   = "2345-7";
        $observation        = $this->myObservation($observation_code, $limit);
        return response()->json([
            'status_code'   => 200,
            'message'       => 'success',
            'data'          => [
                'glucose'   => $observation->original
            ]
        ],200);
    }
    public function observation(Request $request){
        $paginate       = $request->header('paginate');
        $observation    = Observation::where('id_pasien', Auth::id())->paginate($paginate);
        return response()->json([
            'status_code'   => 200,
            'message'       => 'success',
            'data'          => [
                'observations'   => $observation
            ]
        ],200);
    }
    private function myObservation($observation_code, $limit=1){
        $query_ovsrevation = Observation::where([
            'coding.code'   => $observation_code,
            'id_pasien'     => Auth::id()
        ])->orderBy('time', 'DESC')->limit($limit)->get();
        $myObservation  = ObservationResource::collection($query_ovsrevation);

        return response($myObservation);

}

}
