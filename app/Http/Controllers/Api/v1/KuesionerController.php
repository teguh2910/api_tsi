<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Kuesioner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class KuesionerController extends Controller
{
    public function index()
    {
        $kuesioner = Kuesioner::all();
        if($kuesioner->count() < 1){
            $satatus_code   = 404;
            $message        = 'Not Found';
            $data           = [
                'count'     => $kuesioner->count(),
                'kuesioner' => $kuesioner
            ];
        }else{
            $satatus_code   = 200;
            $message        = 'success';
            $data           = [
                'count'     =>  $kuesioner->count(),
                'kuesioner' => $kuesioner
            ];
        }
        return response()->json([
        'status_code'    => $satatus_code,
        'message'        => $message,
        'data'           => $data
        ], $satatus_code);
    }
    public function store(Request $request)
    {
        $validator  = Validator::make($request->all(), [
            'judul'             => 'required',
            'status'            => ['required',Rule::in(['draft', 'publish'])],
            'tanggal_mulai'     => 'date',
            'tanggal_selesai'   => 'date'
        ]);
        if($validator->fails()){
            $satatus_code   = 422;
            $message        = 'gagal validasi';
            $data           = [
                'errors' => $validator->errors()
            ];
        }else{
            $kuesioner      = new Kuesioner();
            $data_kuesioner = [
                "judul"             => $request->judul,
                "status"            => $request->status,
                "tanggal_mulai"     => $request->tanggal_mulai,
                "tanggal_selesai"   => $request->tanggal_selesai,
                "creator"           => [
                    "user_id"   => Auth::id(),
                    "name"      => Auth::user()['nama'],
                    "kontak"    => Auth::user()['kontak'],
                ]
            ];
            $db_kuesioner = Kuesioner::where([
               'judul'              => $request->judul,
               'creator.user_id'    => Auth::id()
            ]);
            if($db_kuesioner->count() > 0 ){
                $satatus_code   = 422;
                $message        = 'Judul kuesioner sudah pernah dibuat';
                $data           = [
                    'kuesioner' => $data_kuesioner
                ];
            }else{
                $create         = $kuesioner->create($data_kuesioner);
                if($create){
                    $satatus_code   = 201;
                    $message        = 'Questionnaire created';
                    $data           = [
                        'kuesioner' => $data_kuesioner
                    ];
                }else{
                    $satatus_code   = 204;
                    $message        = 'Questionnaire not created';
                    $data           = [
                        'kuesioner' => $data_kuesioner
                    ];
                }
            }
        }
        return response()->json([
            'status_code'    => $satatus_code,
            'message'        => $message,
            'data'           => $data
        ], $satatus_code);
    }
    public function update(Request $request)
    {
        $validator  = Validator::make($request->all(), [
            'id_kuesioner'      => 'required',
            'status'            => ['required',Rule::in(['draft', 'publish'])],
            'tanggal_mulai'     => 'date',
            'tanggal_selesai'   => 'date'
        ]);
        if($validator->fails()){
            $satatus_code   = 422;
            $message        = 'gagal validasi';
            $data           = [
                'errors' => $validator->errors()
            ];
        }else{
            $id_kuesioner   = $request->id_kuesioner;
            $kuesioner      = Kuesioner::where('_id', $id_kuesioner)->first();
            if(empty($kuesioner) ){
                $satatus_code   = 404;
                $message        = 'Not Found';
                $data           = [
                    'kuesioner' => $kuesioner
                ];
            }else{
                $data_kuesioner = [
                    "judul"             => $request->judul,
                    "status"            => $request->status,
                    "tanggal_mulai"     => $request->tanggal_mulai,
                    "tanggal_selesai"   => $request->tanggal_selesai
                ];
                $update = $kuesioner->update($data_kuesioner);
                $satatus_code   = 200;
                $message        = 'success';
                $data           = [
                    'kuesioner' => $kuesioner
                ];
            }
        }

        return response()->json([
            'status_code'    => $satatus_code,
            'message'        => $message,
            'data'           => $data
        ], $satatus_code);
    }
}
