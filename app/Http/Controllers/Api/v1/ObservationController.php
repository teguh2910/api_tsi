<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Observation\UpdateObservationRequest;
use App\Models\Code;
use App\Models\Observation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ObservationController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        dd('hallo');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function bloodPressure(Request $request)
    {
        //mencari data observasi
        $code_observasi = 'vital-signs';
        $find_observasi = Code::find($code_observasi);
        $category       = [
            'code'      => $find_observasi->id,
            'display'   => $find_observasi->display,
            'system'    => $find_observasi->system
        ];

        //mencari data systolic dari DB
        $code_systolic  = (string) '8480-6';
        $find_systolic  = Code::find($code_systolic);

        //mencari data diastolic dari db
        $code_diastolic = (string) '8462-4';
        $find_diastolic = Code::find($code_diastolic);

        //mencari data HR
        $code_HR        = '8867-4';
        $find_HR        = Code::find($code_HR);

        $validator      = Validator::make($request->all(), [
            'id_user'       => 'required',
            'systolic'      => 'required|numeric|min:40|max:300',
            'diastolic'     => 'required|numeric|min:10|max:200',
            'heart_rate'    => 'required|numeric|min:10|max:500'
        ]);

        if($validator->fails()){
            return response()->json([
                'status_code'   => 204,
                'message'       => 'gagal validasi',
                'content'       => $validator->errors()
            ]);
        }

        $user = User::find($request->id_user);
        if(empty($user)){
            return response()->json([
               'status_code'    => 404,
               'message'        => 'user not found'
            ],404);
        }

        $systolic   = [
            'value'         => (int) $request->systolic,
            'unit'          => 'mmHg',
            'id_pasien'     => $request->id_user,
            'id_petugas'    => Auth::id(),
            'time'          => time(),
            'coding'        => [
                'code'      => $find_systolic->id,
                'display'   => $find_systolic->display,
                'system'    => $find_systolic->system
            ],
            'category'      => $category

        ];
        $diastolic   = [
            'value'         => (int) $request->diastolic,
            'unit'          => 'mmHg',
            'id_pasien'     => $request->id_user,
            'id_petugas'    => Auth::id(),
            'time'          => time(),
            'coding'        => [
                'code'      => $find_diastolic->id,
                'display'   => $find_diastolic->display,
                'system'    => $find_diastolic->system
            ],
            'category'      => $category
        ];
        $HR         = [
            'value'         => (int) $request->heart_rate,
            'unit'          => "beats/minute",
            'id_pasien'     => $request->id_user,
            'id_petugas'    => Auth::id(),
            'time'          => time(),
            'coding'        => [
                'code'      => $find_HR->id,
                'display'   => $find_HR->display,
                'system'    => $find_HR->system
            ],
            'category'      => $category
        ];
        $observation        = new Observation();
        $create_systolic    = $observation->create($systolic);
        $create_diastolic   = $observation->create($diastolic);
        $create_HR          = $observation->create($HR);
        if($create_systolic && $create_diastolic && $create_HR){
            return response()->json([
                'status_code'   => 200,
                'message'       => 'success'
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Observation\StoreObservationRequest  $request
     * @return \Illuminate\Http\Response
     */

    public function storeRespiratoryRate()
    {
        $data   = [
            "status" => "final",
            "category" => [
                [
                    "coding" => [
                        [
                            "system"    => "http://terminology.hl7.org/CodeSystem/observation-category",
                            "code"      => "vital-signs",
                            "display"   => "Vital Signs"
                        ]
                    ]
                ],
            ],
            "code" =>[
                "coding" => [
                    [
                        "system"    => "http://loinc.org",
                        "code"      => "9279-1",
                        "display"   => "Respiratory rate"
                    ]
                ]
            ],
            "subject" =>[
                "reference" => "Patient/100000030009"

            ],
            "performer" => [
                [
                    "reference" => "Practitioner/N10000001"
                ]
            ],
            "encounter" => [
                "reference" => "Encounter/".md5(uniqid()),
                "display" => "Pemeriksaan Fisik Nadi Budi Santoso di hari Selasa, 14 Juni 2022"
            ],
            "effectiveDateTime" => date('Y-m-d'),
            "issued" => "2022-06-14T07:00:00+07:00",
            "valueQuantity" => [
                "value"     => 80,
                "unit"      => "beats/minute",
                "system"    => "http://unitsofmeasure.org",
                "code"      => "/min"
            ]
        ];
        $observation    = new Observation();
        $create         = $observation->create($data);
        if($create)
        {
            return response()->json([
                'status_code'   => 201,
                'message'       => 'success',
                'time'          => date('Y-m-d H:i:s', 1555902242396)
            ]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Observation  $observation
     * @return \Illuminate\Http\Response
     */
    public function show(Observation $observation)
    {
        //
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
    public function destroy(Observation $observation)
    {
        //
    }
}
