<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
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
            'gelar_depan'   => Auth::user()['gelar']['gelar_depan'],
            'gelar_belakang'=> Auth::user()['gelar']['gelar_belakang'],
            'gender'        => Auth::user()['gender'],
            'username'      => Auth::user()['username'],
            'nik'           => Auth::user()['nik'],
            'email'         => Auth::user()['kontak']['email'],
            'nomor_telepon' => Auth::user()['kontak']['nomor_telepon'],
            'status_pernikahan' => Auth::user()['status_pernikahan'],
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
                'status_code'   =>200,
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
    public function update_email()
    {
        //
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
