<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Observation\StoreObservationRequest;
use App\Models\Observation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HearthRateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hearth_rates = Observation::where([

        ])->get();
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreObservationRequest $request, $id_pasien)
    {
        $pasien         = User::find($id_pasien);
        if(empty($pasien)){
            return response()->json([
                'status_code'   => 404,
                'message'       => 'Not Found'
            ],404);
        }

        $code_db        = '8867-4';
        $category_db    = 'vital-signs';
        $validator      = Validator::make($request->all(), [
            'value'         => 'required|integer|min:25|max:500',
            'id_pasien'     => 'required'
        ]);
        $input              = [
            'category'      => '',
            'code'          => '',
            'value_quantity'=> [
                'value'     => (int)$request->value,
                'unit'      => 'beats/minute'
            ],
            'id_pasien'     => $request->header('id_pasien'),
            'id_petugas'    => Auth()->id(),
            'waktu_periksa' => time(),
        ];
        if ($validator->fails())
        {
            $data = [
                "error"     => $validator->errors(),
                "created"   => time()
            ];
            return response()->json($data,203);
        }else{
            $observation    = new Observation();
            $create         = $observation->create($input );
            if($create)
            {
                return response()->json([
                    'status_code'   => 201,
                    'message'       => 'success',
                    'content'       => $input
                ]);
            }
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
