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

class SystoleController extends Controller
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
        $code_systolic = "8480-6";
        $observation = Observation::where('coding.code',$code_systolic);
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
    public function systole_pasien($id_pasien)
    {
        $code_systolic = "8480-6";
        $observation = Observation::where([
            'coding.code'   => $code_systolic,
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
        $code_systolic  = (string) '8480-6';
        $find_systolic  = Code::where('code', $code_systolic)->first();
        //mencari data diastolic dari db
        if(empty($find_systolic)){
            return response()->json([
                'status_code'   => 404,
                'message'       => 'Not Found'
            ]);
        }

        $validator      = Validator::make($request->all(), [
            'systolic'      => 'required|numeric|min:40|max:300',
            'id_pasien'     => 'required'

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
        $id_user    = $request->id_pasien;
        $user       = User::find($id_user);
        if(empty($user)){
            return response()->json([
               'status_code'    => 404,
               'message'        => 'user not found'
            ],404);
        }

        $systolic   = [
            'value'         => (int) $request->systolic,
            'unit'          => 'mmHg',
            'id_pasien'     => $id_user,
            'id_petugas'    => Auth::id(),
            'time'          => time(),
            'coding'        => [
                'code'      => $find_systolic->code,
                'display'   => $find_systolic->display,
                'system'    => $find_systolic->system
            ],
            'category'      => $category,
            'base_line'     => [
                'min'       => '',
                'max'       => '',
            ],
            'interpretation'    => []

        ];

        $observation        = new Observation();
        $create_systolic    = $observation->create($systolic);

        if($create_systolic){
            return response()->json([
                'status_code'   => 201,
                'message'       => 'success',
                'data'          => [
                    'systole'   => $systolic
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
    public function mysystole()
    {
        $systole = Observation::where('id_pasien', Auth::id())->get();
        $data_systole = SystoleResource::collection($systole);
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
                'systole'   => $data_systole
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
                    'systole'   => "Deleted"
                ]
            ],200);
        }
        return response()->json([
            'status_code'   => 404,
            'message'       => 'Not Found',

        ],404);
    }
}
