<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Observation\UpdateObservationRequest;
use App\Http\Resources\SystoleResource;
use App\Models\Code;
use App\Models\Observation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DiastoleController extends Controller
{
    private function observasi()
    {
        //mencari data observasi
        $code_observasi = 'vital-signs';
        $find_observasi = Code::where('code', $code_observasi)->first();
        $category       = [
            'code'      => $find_observasi->code,
            'display'   => $find_observasi->display,
            'system'    => $find_observasi->system
        ];
        return $category;
    }


    public function index()
    {
        $code = "8462-4";
        $observation = Observation::where('coding.code',$code);
        $data_count = $observation->count();
        $data_observation = SystoleResource::collection($observation->get()) ;
        if($data_count < 1){
            return response()->json([
                'status_code'    => 404,
                'message'        => 'Not Found'
            ],404);

        }
        return response()->json([
           'status_code'    => 200,
           'message'        => 'success',
           'data'           => [
               'systole'    => $data_observation
           ]
        ]);


    }
    public function ByIdPasien($id_pasien)
    {
        $code= "8462-4";
        $observation = Observation::where([
            'coding.code'   => $code,
            'id_pasien'     => $id_pasien
        ]);
        $data_count = $observation->count();
        $data_observation = SystoleResource::collection($observation->get()) ;
        if($data_count < 1){
            return response()->json([
                'status_code'    => 404,
                'message'        => 'Not Found'
            ],404);

        }
        return response()->json([
            'status_code'    => 200,
            'message'        => 'success',
            'data'           => [
                'systole'    => $data_observation
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category       = $this->observasi();
        //mencari data systolic dari DB
        $code           = (string) '8462-4';
        $find_diastole  = Code::where('code', $code)->first();
        //mencari data diastolic dari db
        if(empty($find_diastole)){
            return response()->json([
                'status_code'   => 404,
                'message'       => 'Not Found'
            ]);
        }

        $validator      = Validator::make($request->all(), [
            'diastolic'      => 'required|numeric|min:20|max:200'

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
        $id_user    = $request->header('id_user');
        $user       = User::find($id_user);
        if(empty($user)){
            return response()->json([
               'status_code'    => 404,
               'message'        => 'user not found'
            ],404);
        }

        $systolic   = [
            'value'         => (int) $request->diastolic,
            'unit'          => 'mmHg',
            'id_pasien'     => $id_user,
            'id_petugas'    => Auth::id(),
            'time'          => time(),
            'coding'        => [
                'code'      => $find_diastole->code,
                'display'   => $find_diastole->display,
                'system'    => $find_diastole->system
            ],
            'category'      => $category

        ];

        $observation        = new Observation();
        $create_systolic    = $observation->create($systolic);

        if($create_systolic){
            return response()->json([
                'status_code'   => 201,
                'message'       => 'success',
                'data'          => [
                    'diastole'   => $systolic
                ]
            ],201);
        }
    }

    public function show($id_systole)
    {
        $systole = Observation::find($id_systole);
        if(empty($systole)){
            return response()->json([
                'status_code'   => 404,
                'message'       => 'Not Found',

            ],404);
        }
        return response()->json([
            'status_code'   => 200,
            'message'       => 'Success',
            'data'          => [
                'systole'   => $systole
            ]

        ],200);
    }
    public function mine()
    {
        $code = "8462-4";
        $systole_query = Observation::where([
            'id_pasien'     => Auth::id(),
            'coding.code'   => $code
        ]);
        $systole        = $systole_query->get();
        $systole_count  = $systole_query->count();
        $data_systole   = SystoleResource::collection($systole);
        if($systole_count<1){
            return response()->json([
                'status_code'   => 404,
                'message'       => 'Not Found',

            ],404);
        }
        return response()->json([
            'status_code'   => 200,
            'message'       => 'Success',
            'data'          => [
                'diastole'   => $data_systole
            ]
        ],200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Observation  $observation
     * @return \Illuminate\Http\Response
     */
    public function edit(Observation $observation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Observation\UpdateObservationRequest  $request
     * @param  \App\Models\Observation  $observation
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateObservationRequest $request, Observation $observation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Observation  $observation
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $observation = Observation::destroy($id);
        if($observation){
            return response()->json([
                'status_code'   => 200,
                'message'       => 'Success',
                'data'          => [
                    'diastole'   => "Deleted"
                ]
            ],200);
        }
        return response()->json([
            'status_code'   => 404,
            'message'       => 'Not Found',

        ],404);
    }
}
