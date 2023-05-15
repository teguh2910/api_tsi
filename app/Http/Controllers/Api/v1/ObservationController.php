<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Observation\UpdateObservationRequest;
use App\Http\Resources\ObservationResource;
use App\Models\Code;
use App\Models\Observation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ObservationController extends Controller
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

    public function index(Request $request)
    {
        $code               = $request->code;
        $id_pasien          = $request->id_pasien;
        $order_by           = $request->orderBy;
        $sort               = $request->sort;
        if(isset($request->orderBy) and isset($request->sort)){
            $order_by           = $request->orderBy;
            $sort               = $request->sort;
        }else{
            $order_by           = 'time';
            $sort               = 'ASC';
        }
//        data berdasarkan kode
        if(!isset($request->code)){ //        jika tidak ada code maka ambil semua data observasi
            $status_code    = 200;
            $message        = 'Success';
            $query          = Observation::all();
            return response()->json([
                'status_code'   => $status_code,
                'message'       => $message,
                'data'          => [
                    'observasi' => $query
                ]
            ],$status_code);
        }else if(isset($request->id_pasien)){ // jika ada id pasien
            $query_observasi    = Observation::where([
                'coding.code'   => $code,
                'id_pasien'     => $id_pasien
            ]);
        }else{
            $query_observasi    = Observation::where([
                'coding.code'   => $code,
            ]);
        }
        $count = $query_observasi->count();
        if($count < 1){
            $status_code    = 204;
            $message        = "Data tidak ditemukan";
        }else{
            $status_code    = 200;
            $message        = "success";
        }
        $observation = ObservationResource::collection($query_observasi->orderBy($order_by, $sort)->get()) ;
        return response()->json([
            'status_code'   => $status_code,
            'message'       => $message,
            'data'          => [
                'observation'   => $observation
            ]
        ],$status_code);

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
        $find_systolic  = $this->code($code_systolic)->original;
        //mencari data diastolic dari db
        $code_diastolic = (string) '8462-4';
        $find_diastolic = $this->code($code_diastolic)->original;
        //mencari data HR
        $code_HR        = '8867-4';
        $find_HR        = $this->code($code_HR)->original;;
        if(empty($find_systolic) && empty($find_diastolic) && empty($find_HR)){
            return response()->json([
                'status_code'   => 404,
                'message'       => 'Not Found'
            ]);
        }

        $validator      = Validator::make($request->all(), [
            'systolic'      => 'required|numeric|min:40|max:300',
            'diastolic'     => 'required|numeric|min:10|max:200',
            'heart_rate'    => 'required|numeric|min:10|max:500',
            'id_pasien'     => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'status_code'   => 422,
                'message'       => 'gagal validasi',
                'data'          => [
                    "errors"    => $validator->errors()
                ]

            ],422);
        }
        $id_user        = $request->id_pasien;
        $user           = User::find($id_user);
        $tanggal_lahir  = $user['lahir']['tanggal'];
        $birthDate      = new \DateTime($tanggal_lahir);
        $today          = new \DateTime("today");
        $y              = $today->diff($birthDate)->y;
        $m              = $today->diff($birthDate)->m;
        $d              = $today->diff($birthDate)->d;
        $usia   = [
            'tahun'         => $y,
            'bulan'         => $m,
            'hari'          => $d
        ];
        if(empty($user)){
            return response()->json([
               'status_code'    => 404,
               'message'        => 'pasien tidak terdaftar'
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
                'min'           => 91,
                'max'           => 119,
                'prahipertensi' => 139,
                'hipertensi_1'  => 159,
                'hipertensi_2'  => 180
            ],
            'interpretation'    => []

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
            'category'      => $category,
            'base_line'     => [
                'min'           => 69,
                'max'           => 79,
                'prahipertensi' => 89,
                'hipertensi_1'  => 99,
                'hipertensi_2'  => 100
            ],
            'interpretation'    => []
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
            'category'      => $category,
            'base_line'     => [
                'min'       => 60,
                'max'       => 80
            ],
            'interpretation'    => []
        ];
        $observation        = new Observation();
        $create_systolic    = $observation->create($systolic);
        $create_diastolic   = $observation->create($diastolic);
        $create_HR          = $observation->create($HR);
        if($create_systolic && $create_diastolic && $create_HR){
            return response()->json([
                'status_code'   => 201,
                'message'       => 'success',
                'data'          => [
                    'usia'          => $usia,
                    'bloodpressure' => [
                        'systolic'  => $systolic,
                        'diastolic' => $diastolic,
                        'heart_rate'=> $HR
                    ]
                ]
            ], 201);
        }
    }
    public function hearth_rate(Request $request){
        $category       = $this->observasi();
        $validator      = Validator::make($request->all(), [
            'heart_rate'    => 'required|numeric|min:10|max:500',
            'id_pasien'     => 'required'
        ]);
        $code_HR        = '8867-4';
        $find_HR        = Code::where('code', $code_HR)->first();
        $id_user        = $request->id_pasien;
        $user           = User::find($id_user);
        if(empty($find_HR)){
            return response()->json([
                'status_code'   => 404,
                'message'       => 'Not Found'
            ]);
        }elseif($validator->fails()){
            return response()->json([
                'status_code'   => 422,
                'message'       => 'gagal validasi',
                'data'          => [
                    "errors"    => $validator->errors()
                ]

            ],422);
        }elseif(empty($user)){
            return response()->json([
                'status_code'    => 404,
                'message'        => 'pasien tidak terdaftar'
            ],404);
        }else{
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
                'category'      => $category,
                'base_line'     => [
                    'min'       => 60,
                    'max'       => 80
                ],
                'interpretation'    => []
            ];
            $observation        = new Observation();
            $create_HR          = $observation->create($HR);
            if($create_HR){
                return response()->json([
                    'status_code'   => 201,
                    'message'       => 'success',
                    'data'          => [
                        'heart_rate' => $HR
                    ]
                ], 201);
            }

        }





    }

    public function temperature(Request $request)
    {
        //mencari data observasi
        $category       = $this->observasi();
        $id_pasien      = $request->id_pasien;
        $pasien         = User::find($id_pasien);
        if(empty($pasien)){
            return response()->json([
                'status_code'   => 404,
                'message'       => 'Pasien tidak ditemukan'
            ],404);
        }
        //mencari data temperature dari DB
        $code_suhu      = (string) '8310-5';
        $find_suhu      = Code::find($code_suhu);
        $validator      = Validator::make($request->all(), [
            'suhu'      => 'required|numeric|min:35|max:45',
            'id_pasien' => 'required'
        ]);
        if($validator->fails()){
            return response()->json([
                'status_code'   => 422,
                'message'       => 'Gagal Validasi',
                'data'          => [
                    'errors'    => $validator->errors()
                ]
            ],422);
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
            'category'      => $category,
            'base_line'     => [
                'min'       => 36,
                'max'       => 37.4
            ],
            'interpretation'=>[

            ]
        ];
        $observation        = new Observation();
        $create_suhu        = $observation->create($suhu);
        if($create_suhu){
            return response()->json([
                'status_code'   => 201,
                'message'       => 'success',
                'data'          => [
                    'body_temperature'  => $suhu
                ]
            ], 201);
        }
    }

    public function weight(Request $request)
    {
        $category       = $this->observasi();
        $code_wight = "29463-7";
        $find_wight = Code::where('code', $code_wight)->first();

        $id_pasien  = $request->id_pasien;
        $user       = User::find($id_pasien);
        if(empty($user)){
            return response()->json([
                'status_code'   => 404,
                'message'       => 'User Not Found'
            ],404);
        }
        $validation = Validator::make($request->all(),[
            'weight'    => 'required|numeric|min:1|max:300',
            'id_pasien' => 'required'
        ]);
        if($validation->fails())
        {
            return response()->json([
                'status_code'   => 422,
                'message'       => 'Gagal validasi',
                'content'       => $validation->errors()
            ],422);
        }
        $data         = [
            'value'         => (float) $request->weight,
            'unit'          => "Kg",
            'id_pasien'     => $id_pasien,
            'id_petugas'    => Auth::id(),
            'time'          => time(),
            'coding'        => [
                'code'      => $find_wight->code,
                'display'   => $find_wight->display,
                'system'    => $find_wight->system
            ],
            'category'      => $category,
            'base_line'     => [

            ],
            'interpretation'=>[

            ]
        ];
        $observation    = new Observation();
        $create         = $observation->create($data);
        if($create)
        {
            return response()->json([
                'status_code'   => 201,
                'message'       => 'success',
                'data'          => [
                    'body_weight'   => $data
                ]

            ]);
        }

    }
    public function height(Request $request)
    {
        $code_observasi = 'vital-signs';
        $find_observasi = Code::where('code',$code_observasi)->first();
        $category       = [
            'code'      => $find_observasi->code,
            'display'   => $find_observasi->display,
            'system'    => $find_observasi->system
        ];
        $code_height    = "8302-2";
        $find_height    = Code::where('code', $code_height)->first();
        $id_pasien      = $request->id_pasien;
        $user           = User::find($id_pasien);
        if(empty($user)){
            return response()->json([
                'status_code'   => 404,
                'message'       => 'User Not Found'
            ],404);
        }
        $validation = Validator::make($request->all(),[
            'height'    => 'required|numeric|min:40|max:250',
            'id_pasien' => 'required'
        ]);
        if($validation->fails())
        {
            return response()->json([
                'status_code'   => 422,
                'message'       => 'Gagal validasi',
                'data'          => [
                    'errors'    => $validation->errors()
                ]
            ],422);
        }
        $data         = [
            'value'         => (float) $request->height,
            'unit'          => "CM",
            'id_pasien'     => $id_pasien,
            'id_petugas'    => Auth::id(),
            'time'          => time(),
            'coding'        => [
                'code'      => $find_height->code,
                'display'   => $find_height->display,
                'system'    => $find_height->system
            ],
            'category'      => $category,
            'base_line'     => [],
            'interpretation'=> []
        ];
        $observation    = new Observation();
        $create         = $observation->create($data);
        if($create)
        {
            return response()->json([
                'status_code'   => 201,
                'message'       => 'success',
                'data'          => [
                    'body_height'   => $data
                ]

            ]);
        }

    }
    public function bmi(){
        $code = "39156-5";
    }
    private function code($code){
        $code   = Code::where('code', $code)->first();
        if(empty($code)){
            return response()->json([
                'status_code'   => 404,
                'message'       => 'User Not Found'
            ],404);
        }
        return response($code);

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
