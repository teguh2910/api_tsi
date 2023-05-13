<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Religion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReligionController extends Controller
{
    public function index ()
    {
        $religion = Religion::all();
        return response()->json([
            'status_code'   => 200,
            'message'       => 'success',
            'data'          => [
                "religion"    => $religion
            ],
        ]);
    }
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'agama'         => 'required|min:5|unique:religions,name',
            'kitab_suci'    => 'required'
        ]);
        if($validator->fails()){
            return response()->json([
                'status_code'   => 203,
                'message'       => 'Gagal validasi',
                'data'          => [
                    'errors'    => $validator->errors()
                ]
            ], 422);
        }
        $agama = new Religion();
        $data_input = [
            'name'          => $request->agama,
            'kitab_suci'    => $request->kitab_suci
        ];
        $add    = $agama->create($data_input);
        if($add){
            return response()->json([
                'status_code'   => 201,
                'message'       => 'Success',
                'data'          => [
                    'religion'    => $data_input
                ]
            ], 201);

        }
    }
}
