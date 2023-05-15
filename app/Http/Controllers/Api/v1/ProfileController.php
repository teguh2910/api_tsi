<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Wilayah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{

    public function index()
    {
        $data_user = [
            'id'            => Auth::id(),
            'nama_depan'    => Auth::user()['nama']['nama_depan'],
            'nama_belakang' => Auth::user()['nama']['nama_belakang'],
            'gender'        => Auth::user()['gender'],
            'username'      => Auth::user()['username'],
            'nik'           => Auth::user()['nik'],
            'email'         => Auth::user()['kontak']['email'],
            'nomor_telepon' => Auth::user()['kontak']['nomor_telepon'],
            'status_pernikahan' => Auth::user()['status_pernikahan'],
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
    public function health_over_view(){
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

        return response()->json([
            'status_code'   => 200,
            'message'       => 'success',
            'data'          => [
                'today'             => $today,
                'gender'            => Auth::user()['gender'],
                'usia'              => $usia,
                'systole'           => "ditemukan",
                'diastole'          => '',
                'hearth_rate'       => '',
                'body_temperature'  => '',
                'body_weight'       => '',
                'body_height'       => '',
                'oxygen_saturation' => '',
                'blood_glucose'     => '',
                'blood_cholesterole'=> '',
                'uric_acid'         => '',
                'bmi'               => ''
            ]
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
    public function edit($id)
    {
        //
    }


    public function update(Request $request)
    {
        //
    }

}
