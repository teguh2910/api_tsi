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

class BloodPressure extends Controller
{

    /**
     * Menghitung jumlah record yang telah dilakukan oleh petugas.
     *
     * @return \Illuminate\Http\Response
     */
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
        $observation = Observation::all();
        if(empty($observation)){
            return response()->json([
                'status_code'    => 404,
                'message'        => 'Not Found'
            ],404);

        }
        return response()->json([
           'status_code'    => 200,
           'message'        => 'success',
           'content'        =>  $observation
        ]);


    }
    public function count()
    {
        $observation    = Observation::where('id_petugas', Auth::id())->count() ;
        return response()->json([
            'status_code'   => 200,
            'message'       => 'success',
            'count'         => $observation

        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function bloodPressure(Request $request)
    {
        $category       = $this->observasi();
        //mencari data systolic dari DB
        $code_systolic  = (string) '8480-6';
        $find_systolic  = Code::where('code', $code_systolic)->first();
        //mencari data diastolic dari db
        $code_diastolic = (string) '8462-4';
        $find_diastolic = Code::where('code', $code_diastolic)->first();
        //mencari data HR
        $code_HR        = '8867-4';
        $find_HR        = Code::where('code', $code_HR)->first();
        if(empty($find_systolic) && empty($find_diastolic) && empty($find_HR)){
            return response()->json([
                'status_code'   => 404,
                'message'       => 'Not Found'
            ]);
        }

        $validator      = Validator::make($request->all(), [
            'systolic'      => 'required|numeric|min:40|max:300',
            'diastolic'     => 'required|numeric|min:10|max:200',
            'heart_rate'    => 'required|numeric|min:10|max:500'
        ]);

        if($validator->fails()){
            return response()->json([
                'status_code'   => 422,
                'message'       => 'gagal validasi',
                'content'       => $validator->errors()
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
            'category'      => $category

        ];
        $diastolic   = [
            'value'         => (int) $request->diastolic,
            'unit'          => 'mmHg',
            'id_pasien'     => $id_user,
            'id_petugas'    => Auth::id(),
            'time'          => time(),
            'coding'        => [
                'code'      => $find_diastolic->code,
                'display'   => $find_diastolic->display,
                'system'    => $find_diastolic->system
            ],
            'category'      => $category
        ];
        $HR         = [
            'value'         => (int) $request->heart_rate,
            'unit'          => "beats/minute",
            'id_pasien'     => $id_user,
            'id_petugas'    => Auth::id(),
            'time'          => time(),
            'coding'        => [
                'code'      => $find_HR->code,
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

    public function temperatur(Request $request)
    {
        //mencari data observasi
        $category       = $this->observasi();
        $id_pasien      = $request->header('id_user');
        $pasien         = User::find($id_pasien);
        if(empty($pasien)){
            return response()->json([
                'status_code'   => 404,
                'message'       => 'user not found'
            ]);
        }
        //mencari data temperature dari DB
        $code_suhu      = (string) '8310-5';
        $find_suhu      = Code::find($code_suhu);
        $validator      = Validator::make($request->all(), [
            'suhu'  => 'required|numeric|min:35|max:45'
        ]);
        if($validator->fails()){
            return response()->json([
                'status_code'   => 204,
                'message'       => 'Gagal Validasi',
                'content'       => $validator->errors()
            ]);
        }
        $suhu         = [
            'value'         => (float) $request->suhu,
            'unit'          => "C",
            'id_pasien'     => $id_pasien,
            'id_petugas'    => Auth::id(),
            'time'          => time(),
            'coding'        => [
                "code"      => "8310-5",
                "display"   => "Body temperature",
                "system"    => "http://loinc.org"
            ],
            'category'      => $category
        ];
        $observation        = new Observation();
        $create_suhu        = $observation->create($suhu);
        if($create_suhu){
            return response()->json([
                'status_code'   => 201,
                'message'       => 'success'
            ], 201);
        }
    }

    public function weight(Request $request)
    {

        $category       = $this->observasi();
        $code_wight = "29463-7";
        $find_wight = Code::find($code_wight);

        $id_user    = $request->header('id_user');
        $user       = User::find($id_user);
        if(empty($user)){
            return response()->json([
                'status_code'   => 404,
                'message'       => 'User Not Found'
            ]);
        }
        $validation = Validator::make($request->all(),[
            'weight'    => 'required|numeric|min:1|max:300'
        ]);
        if($validation->fails())
        {
            return response()->json([
                'status_code'   => 304,
                'message'       => 'Gagal validasi',
                'content'       => $validation->errors()
            ]);
        }
        $data         = [
            'value'         => (int) $request->weight,
            'unit'          => "Kg",
            'id_pasien'     => $id_user,
            'id_petugas'    => Auth::id(),
            'time'          => time(),
            'coding'        => [
                'code'      => $find_wight->code,
                'display'   => $find_wight->display,
                'system'    => $find_wight->system
            ],
            'category'      => $category
        ];
        $observation    = new Observation();
        $create         = $observation->create($data);
        if($create)
        {
            return response()->json([
                'status_code'   => 201,
                'message'       => 'success'

            ]);
        }

    }
    public function height(Request $request)
    {
        $code_observasi = 'vital-signs';
        $find_observasi = Code::find($code_observasi);
        $category       = [
            'code'      => $find_observasi->code,
            'display'   => $find_observasi->display,
            'system'    => $find_observasi->system
        ];
        $code_height = "8302-2";
        $find_height = Code::find($code_height);

        $id_user    = $request->header('id_user');
        $user       = User::find($id_user);
        if(empty($user)){
            return response()->json([
                'status_code'   => 404,
                'message'       => 'User Not Found'
            ]);
        }
        $validation = Validator::make($request->all(),[
            'height'    => 'required|numeric|min:40|max:250'
        ]);
        if($validation->fails())
        {
            return response()->json([
                'status_code'   => 304,
                'message'       => 'Gagal validasi',
                'content'       => $validation->errors()
            ]);
        }
        $data         = [
            'value'         => (int) $request->height,
            'unit'          => "Kg",
            'id_pasien'     => $id_user,
            'id_petugas'    => Auth::id(),
            'time'          => time(),
            'coding'        => [
                'code'      => $find_height->code,
                'display'   => $find_height->display,
                'system'    => $find_height->system
            ],
            'category'      => $category
        ];
        $observation    = new Observation();
        $create         = $observation->create($data);
        if($create)
        {
            return response()->json([
                'status_code'   => 201,
                'message'       => 'success'

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
