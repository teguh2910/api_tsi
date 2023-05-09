<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\WilayahResource;
use App\Models\Wilayah;
use Illuminate\Http\Request;

class WilayahController extends Controller
{
    public function index(){
        $wilayah    = WilayahResource::collection(Wilayah::where('nama', '!=', NULL)->limit(100)->get());
        return response()->json([
            'status_code'   => 200,
            'message'       => 'success',
            'data'          => [
                'wilayah'  => $wilayah
            ]
        ]);
    }
    public function provinsi(){
        $wilayah    = WilayahResource::collection(Wilayah::where('wilayah', 'Provinsi')->get());
        return response()->json([
            'status_code'   => 200,
            'message'       => 'success',
            'data'          => [
                'provinsi'  => $wilayah
            ]
        ]);
    }
    public function kota(Request $request){
        $code_provinsi = $request->code_provinsi;
        if(isset($request->code_provinsi)){
            $wilayah    = WilayahResource::collection(Wilayah::where('wilayah', 'Kota')->where('provinsi',$code_provinsi )->get());
        }else{
            $wilayah    = WilayahResource::collection(Wilayah::where('wilayah', 'Kota')->get());
        }

        return response()->json([
            'status_code'   => 200,
            'message'       => 'success',
            'data'          => [
                'code_provinsi' => $code_provinsi,
                'kota'          => $wilayah
            ]
        ]);
    }
    public function kecamatan(Request $request){
        $code_kota = $request->code_kota;
        if(isset($request->code_kota)){
            $wilayah    = WilayahResource::collection(Wilayah::where('wilayah', 'Kecamatan')->where('kota',$code_kota )->get());
        }else{
            $wilayah    = WilayahResource::collection(Wilayah::where('wilayah', 'Kecamatan')->get());
        }

        return response()->json([
            'status_code'   => 200,
            'message'       => 'success',
            'data'          => [
                'code_kota' => $code_kota,
                'kota'      => $wilayah
            ]
        ]);
    }
    public function kelurahan(Request $request){
        $code_kecamatan = $request->code_kecamatan;
        if(isset($request->code_kecamatan)){
            $wilayah    = WilayahResource::collection(Wilayah::where('wilayah', 'Kelurahan')->where('kecamatan',$code_kecamatan )->get());
        }else{
            $wilayah    = WilayahResource::collection(Wilayah::where('wilayah', 'Kecamatan')->get());
        }

        return response()->json([
            'status_code'   => 200,
            'message'       => 'success',
            'data'          => [
                'code_kecamatan' => $code_kecamatan,
                'kota'          => $wilayah
            ]
        ]);
    }

}
