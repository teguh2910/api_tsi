<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Observation\StoreObservationRequest;
use App\Http\Requests\Observation\UpdateObservationRequest;
use App\Models\Observation;
use DateTime;
use DateTimeZone;
use http\Client\Response;
use Illuminate\Auth\Events\Validated;
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
    public function create()
    {
        //
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
