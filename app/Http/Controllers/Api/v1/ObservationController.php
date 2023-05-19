<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Observation\UpdateObservationRequest;
use App\Http\Resources\ObservationResource;
use App\Models\Code;
use App\Models\Kit;
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
        $code_HR            = '8867-4';
        $find_HR            = $this->code($code_HR)->original;
        $value_systolic     = $request->systolic;
        $value_diastolic    = $request->diastolic;
        $value_hr           = $request->heart_rate;
        $min_systolic       = 90;
        $max_systolic       = 129;

        if($value_systolic < $min_systolic){
            $interpretation_code_systole       = 'L';
            $interpretation_display_systole    = "Low";
        }elseif($value_systolic > $max_systolic){
            $interpretation_code_systole       = 'H';
            $interpretation_display_systole    = "High";

        }else{
            $interpretation_code_systole       = 'N';
            $interpretation_display_systole    = "Normal";
        }
        $min_diastolic      = 60;
        $max_diastolic      = 79;
        if($value_diastolic < $min_diastolic){
            $interpretation_code_diastolic       = 'L';
            $interpretation_display_diastolic    = "Low";
        }elseif($value_diastolic > $max_diastolic){
            $interpretation_code_diastolic       = 'H';
            $interpretation_display_diastolic    = "High";

        }else{
            $interpretation_code_diastolic       = 'N';
            $interpretation_display_diastolic    = "Normal";
        }

        if(empty($find_systolic) && empty($find_diastolic) && empty($find_HR)){
            return response()->json([
                'status_code'   => 404,
                'message'       => 'Not Found'
            ]);
        }
        $min_hr             = 80;
        $max_hr             = 100;
        if($value_hr < $min_hr){
            $interpretation_code_hr       = 'L';
            $interpretation_display_hr    = "Low";
        }elseif($value_hr > $max_hr){
            $interpretation_code_hr       = 'H';
            $interpretation_display_hr    = "High";

        }else{
            $interpretation_code_hr       = 'N';
            $interpretation_display_hr    = "Normal";
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
            'atm_sehat'     => [
                'code_kit'  => Auth::user()['kit']['kit_code']
            ],
            'time'          => time(),
            'coding'        => [
                'code'      => $find_systolic->code,
                'display'   => $find_systolic->display,
                'system'    => $find_systolic->system
            ],
            'category'      => $category,
            'base_line'     => [
                'min'           => $min_systolic,
                'max'           => $max_systolic
            ],
            'interpretation'=> [
                'code'      => $interpretation_code_systole,
                'display'   => $interpretation_display_systole,
                'system'    => 'http://terminology.hl7.org/CodeSystem/v3-ObservationInterpretation'
            ]

        ];
        $diastolic   = [
            'value'         => (int) $request->diastolic,
            'unit'          => 'mmHg',
            'id_pasien'     => $id_user,
            'id_petugas'    => Auth::id(),
            'atm_sehat'     => [
                'code_kit'  => Auth::user()['kit']['kit_code']
            ],
            'time'          => time(),
            'coding'        => [
                'code'      => $find_diastolic->code,
                'display'   => $find_diastolic->display,
                'system'    => $find_diastolic->system
            ],
            'category'      => $category,
            'base_line'     => [
                'min'           => $min_diastolic,
                'max'           => $max_diastolic
            ],
            'interpretation'=> [
                'code'      => $interpretation_code_diastolic,
                'display'   => $interpretation_display_diastolic,
                'system'    => 'http://terminology.hl7.org/CodeSystem/v3-ObservationInterpretation'
            ]
        ];
        $HR         = [
            'value'         => (int) $request->heart_rate,
            'unit'          => "beats/minute",
            'id_pasien'     => $id_user,
            'id_petugas'    => Auth::id(),
            'atm_sehat'     => [
                'code_kit'  => Auth::user()['kit']['kit_code']
            ],
            'time'          => time(),
            'coding'        => [
                'code'      => $find_HR->code,
                'display'   => $find_HR->display,
                'system'    => $find_HR->system
            ],
            'category'      => $category,
            'base_line'     => [
                'min'           => $min_hr,
                'max'           => $max_hr
            ],
            'interpretation'=> [
                'code'      => $interpretation_code_hr,
                'display'   => $interpretation_display_hr,
                'system'    => 'http://terminology.hl7.org/CodeSystem/v3-ObservationInterpretation'
            ]
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
        $value_periksa  = (float) $request->heart_rate;
        $value_min      = 60;
        $value_max      = 80;
        if($value_periksa < $value_min ){
            $interpretation_code       = 'L';
            $interpretation_display    = "Low";
        }elseif($value_periksa > $value_max){
            $interpretation_code       = 'H';
            $interpretation_display    = "High";

        }else{
            $interpretation_code       = 'N';
            $interpretation_display    = "Normal";
        }
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
                'interpretation'=> [
                    'code'      => $interpretation_code,
                    'display'   => $interpretation_display,
                    'system'    => 'http://terminology.hl7.org/CodeSystem/v3-ObservationInterpretation'
                ]
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
        $value_periksa  = (float) $request->suhu;
        $value_min      = 36;
        $value_max      = 37.5;
        if($value_periksa < $value_min ){
            $interpretation_code       = 'L';
            $interpretation_display    = "Low";
        }elseif($value_periksa > $value_max){
            $interpretation_code       = 'H';
            $interpretation_display    = "High";

        }else{
            $interpretation_code       = 'N';
            $interpretation_display    = "Normal";
        }
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
            'atm_sehat'     => [
                'code_kit'  => Auth::user()['kit']['kit_code']
            ],
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
            'interpretation'=> [
                'code'      => $interpretation_code,
                'display'   => $interpretation_display,
                'system'    => 'http://terminology.hl7.org/CodeSystem/v3-ObservationInterpretation'
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
        $code_wight     = "29463-7";
        $find_wight     = Code::where('code', $code_wight)->first();

        $code_bmi           = "39156-5";
        $fine_bmi           = Code::where('code', $code_bmi)->first();
        $id_pasien          = $request->id_pasien;
        $value_weight       = (float) $request->weight;
        $code_height        = "8302-2";
        $las_body_height    = Observation::where('id_pasien', $id_pasien)->where('coding.code', $code_height)->first();

        if($las_body_height->value != NULL){
            $kuadrat_tb = (($las_body_height->value/100)*($las_body_height->value/100));
            $value_bmi = ($value_weight/$kuadrat_tb);
            $this->bmi($value_bmi,$id_pasien,Auth::id(), Auth::user()['kit']['kit_code']);
        }else{
            $value_bmi = NULL;
        }
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
            'value'         => $value_weight,
            'unit'          => "Kg",
            'id_pasien'     => $id_pasien,
            'id_petugas'    => Auth::id(),
            'atm_sehat'     => [
                'code_kit'  => Auth::user()['kit']['kit_code']
            ],
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
        $value_height   = (float) $request->height;

        $code_weight        = "29463-7";
        $las_body_weight    = Observation::where('id_pasien', $id_pasien)->where('coding.code', $code_weight)->first();

        if($las_body_weight->value != NULL){
            $kuadrat_tb = ($value_height/100)*($value_height/100);
            $value_bmi = ($las_body_weight->value/$kuadrat_tb);
            $this->bmi($value_bmi,$id_pasien,Auth::id(), Auth::user()['kit']['kit_code']);
        }else{
            $value_bmi = NULL;
        }
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
            'value'         => $value_height,
            'unit'          => "CM",
            'bmi'           => $value_bmi,
            'id_pasien'     => $id_pasien,
            'id_petugas'    => Auth::id(),
            'atm_sehat'     => [
                'code_kit'  => Auth::user()['kit']['kit_code']
            ],
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
    public function spo2(Request $request)
    {
        $code_observasi = 'vital-signs';
        $find_observasi = Code::where('code',$code_observasi)->first();
        $category       = [
            'code'      => $find_observasi->code,
            'display'   => $find_observasi->display,
            'system'    => $find_observasi->system
        ];
        $code_spo2      = "59408-5";
        $find_spo2      = Code::where('code', $code_spo2)->first();
        $id_pasien      = $request->id_pasien;
        $user           = User::find($id_pasien);
        $value_periksa  = (float) $request->spo2;
        $value_min      = 95;
        $value_max      = 100;
        if($value_periksa < $value_min ){
            $interpretation_code       = 'L';
            $interpretation_display    = "Low";
        }elseif($value_periksa > $value_max){
            $interpretation_code       = 'H';
            $interpretation_display    = "High";

        }else{
            $interpretation_code       = 'N';
            $interpretation_display    = "Normal";
        }
        if(empty($user)){
            return response()->json([
                'status_code'   => 404,
                'message'       => 'User Not Found'
            ],404);
        }
        $validation = Validator::make($request->all(),[
            'spo2'      => 'required|numeric|min:40|max:100',
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
            'value'         => (float) $request->spo2,
            'unit'          => "%",
            'id_pasien'     => $id_pasien,
            'id_petugas'    => Auth::id(),
            'atm_sehat'     => [
                'code_kit'  => Auth::user()['kit']['kit_code']
            ],
            'time'          => time(),
            'coding'        => [
                'code'      => $find_spo2->code,
                'display'   => $find_spo2->display,
                'system'    => $find_spo2->system
            ],
            'category'      => $category,
            'base_line'     => [
                'min'       => '95',
                'max'       => '100'
            ],
            'interpretation'=> [
                'code'      => $interpretation_code,
                'display'   => $interpretation_display,
                'system'    => 'http://terminology.hl7.org/CodeSystem/v3-ObservationInterpretation'
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
                    'spo2'   => $data
                ]

            ]);
        }

    }
    public function uric_acid(Request $request)
    {
        $code_observasi = 'laboratory';
        $find_observasi = Code::where('code',$code_observasi)->first();
        $category       = [
            'code'      => $find_observasi->code,
            'display'   => $find_observasi->display,
            'system'    => $find_observasi->system
        ];
        $code_UA        = "3084-1";
        $find_UA        = Code::where('code', $code_UA)->first();
        $id_pasien      = $request->id_pasien;
        $user           = User::find($id_pasien);
        $value_periksa  = (float) $request->uric_acid;
        $value_min      = 3.4;
        $value_max      = 7.0;
        if($value_periksa < $value_min ){
            $interpretation_code       = 'L';
            $interpretation_display    = "Low";
        }elseif($value_periksa > $value_max){
            $interpretation_code       = 'H';
            $interpretation_display    = "High";

        }else{
            $interpretation_code       = 'N';
            $interpretation_display    = "Normal";
        }
        if(empty($user)){
            return response()->json([
                'status_code'   => 404,
                'message'       => 'User Not Found'
            ],404);
        }
        $validation = Validator::make($request->all(),[
            'uric_acid'     => 'required|numeric|min:1|max:100',
            'id_pasien'     => 'required'
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
            'value'         => $value_periksa,
            'unit'          => "mg/dL",
            'id_pasien'     => $id_pasien,
            'id_petugas'    => Auth::id(),
            'atm_sehat'     => [
                'code_kit'  => Auth::user()['kit']['kit_code']
            ],
            'time'          => time(),
            'coding'        => [
                'code'      => $find_UA->code,
                'display'   => $find_UA->display,
                'system'    => $find_UA->system
            ],
            'category'      => $category,
            'base_line'     => [
                'min'       => (float) $value_min,
                'max'       => (float) $value_max
            ],
            'interpretation'=> [
                'code'      => $interpretation_code,
                'display'   => $interpretation_display,
                'system'    => 'http://terminology.hl7.org/CodeSystem/v3-ObservationInterpretation'
            ]
        ];
        $observation        = new Observation();
        $create             = $observation->create($data);
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
    public function cholesterol(Request $request)
    {
        $code_observasi = 'laboratory';
        $find_observasi = Code::where('code',$code_observasi)->first();
        $category       = [
            'code'      => $find_observasi->code,
            'display'   => $find_observasi->display,
            'system'    => $find_observasi->system
        ];
        $code_chole     = "2093-3";
        $find_chole     = Code::where('code', $code_chole)->first();
        $id_pasien      = $request->id_pasien;
        $user           = User::find($id_pasien);
        $value_periksa  = (float) $request->cholesterol;
        $value_min      = 125;
        $value_max      = 200;
        if($value_periksa < $value_min ){
            $interpretation_code       = 'L';
            $interpretation_display    = "Low";
        }elseif($value_periksa > $value_max){
            $interpretation_code       = 'H';
            $interpretation_display    = "High";

        }else{
            $interpretation_code       = 'N';
            $interpretation_display    = "Normal";
        }
        if(empty($user)){
            return response()->json([
                'status_code'   => 404,
                'message'       => 'User Not Found'
            ],404);
        }
        $validation = Validator::make($request->all(),[
            'cholesterol'   => 'required|numeric|min:10|max:600',
            'id_pasien'     => 'required'
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
            'value'         => $value_periksa,
            'unit'          => "mg/dL",
            'id_pasien'     => $id_pasien,
            'id_petugas'    => Auth::id(),
            'atm_sehat'     => [
                'code_kit'  => Auth::user()['kit']['kit_code']
            ],
            'time'          => time(),
            'coding'        => [
                'code'      => $find_chole->code,
                'display'   => $find_chole->display,
                'system'    => $find_chole->system
            ],
            'category'      => $category,
            'base_line'     => [
                'min'       => (float) $value_min,
                'max'       => (float) $value_max
            ],
            'interpretation'=> [
                'code'      => $interpretation_code,
                'display'   => $interpretation_display,
                'system'    => 'http://terminology.hl7.org/CodeSystem/v3-ObservationInterpretation'
            ]
        ];
        $observation        = new Observation();
        $create             = $observation->create($data);
        if($create)
        {
            return response()->json([
                'status_code'   => 201,
                'message'       => 'success',
                'data'          => [
                    'cholesterol'   => $data
                ]

            ]);
        }

    }
    public function blood_glucose(Request $request)
    {
        $code_observasi = 'laboratory';
        $find_observasi = Code::where('code',$code_observasi)->first();
        $category       = [
            'code'      => $find_observasi->code,
            'display'   => $find_observasi->display,
            'system'    => $find_observasi->system
        ];
        $code_glucose   = "2345-7";
        $find_glucose   = Code::where('code', $code_glucose)->first();
        $id_pasien      = $request->id_pasien;
        $user           = User::find($id_pasien);
        $value_periksa  = (float) $request->glucose;
        $value_min      = 70;
        $value_max      = 140;
        if($value_periksa < $value_min ){
            $interpretation_code       = 'L';
            $interpretation_display    = "Low";
        }elseif($value_periksa > $value_max){
            $interpretation_code       = 'H';
            $interpretation_display    = "High";

        }else{
            $interpretation_code       = 'N';
            $interpretation_display    = "Normal";
        }
        if(empty($user)){
            return response()->json([
                'status_code'   => 404,
                'message'       => 'User Not Found'
            ],404);
        }
        $validation = Validator::make($request->all(),[
            'glucose'       => 'required|numeric|min:10|max:600',
            'id_pasien'     => 'required'
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
            'value'         => $value_periksa,
            'unit'          => "mg/dL",
            'id_pasien'     => $id_pasien,
            'id_petugas'    => Auth::id(),
            'atm_sehat'     => [
                'code_kit'  => Auth::user()['kit']['kit_code']
            ],
            'time'          => time(),
            'coding'        => [
                'code'      => $find_glucose->code,
                'display'   => $find_glucose->display,
                'system'    => $find_glucose->system
            ],
            'category'      => $category,
            'base_line'     => [
                'min'       => (float) $value_min,
                'max'       => (float) $value_max
            ],
            'interpretation'=> [
                'code'      => $interpretation_code,
                'display'   => $interpretation_display,
                'system'    => 'http://terminology.hl7.org/CodeSystem/v3-ObservationInterpretation'
            ]
        ];
        $observation        = new Observation();
        $create             = $observation->create($data);
        if($create)
        {
            return response()->json([
                'status_code'   => 201,
                'message'       => 'success',
                'data'          => [
                    'glucose'   => $data
                ]

            ]);
        }

    }
    public function gd(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'glucose'       => 'required|numeric|min:10|max:600',
            'id_pasien'     => 'required'
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
        }else{
            $category_code  = 'laboratory';
            $code_glucose   = "2345-7";
            $unit           = [
                'code'      => 'mg/dL',
                'display'   => 'mg/dL',
                'system'    => 'http://unitsofmeasure.org'
            ];
            $id_pasien      = $request->id_pasien;
            $value_periksa  = (float) $request->glucose;
            $value_min      = 70;
            $value_max      = 140;
            $base_line      = [
                'min'       => $value_min,
                'max'       => $value_max
            ];

            if($value_periksa < $value_min ){
                $interpretation_code       = 'L';
                $interpretation_display    = "Low";
            }elseif($value_periksa > $value_max){
                $interpretation_code       = 'H';
                $interpretation_display    = "High";

            }else{
                $interpretation_code       = 'N';
                $interpretation_display    = "Normal";
            }
            $interpretation     = [
                'code'      => $interpretation_code,
                'display'   => $interpretation_display,
                'system'    => 'http://terminology.hl7.org/CodeSystem/v3-ObservationInterpretation'
            ];
//            echo "sukses";

            $save = $this->save($value_periksa, $unit, $id_pasien, $code_glucose, $category_code, $base_line, $interpretation);
            return response($save);
        }


    }
    private function bmi($value_bmi, $id_pasien, $id_pemeriksa, $id_kit){

        $code_observasi = 'vital-signs';
        $find_observasi = Code::where('code',$code_observasi)->first();
        $category       = [
            'code'      => $find_observasi->code,
            'display'   => $find_observasi->display,
            'system'    => $find_observasi->system
        ];
        $bmi_code       = "39156-5";
        $find_bmi       = Code::where('code', $bmi_code)->first();
        $user           = User::find($id_pasien);
        $value_periksa  = (float) $value_bmi;
        $value_min      = 18.5;
        $value_max      = 24.9;
        if($value_periksa < $value_min ){
            $interpretation_code       = 'L';
            $interpretation_display    = "Low";
        }elseif($value_periksa > $value_max){
            $interpretation_code       = 'H';
            $interpretation_display    = "High";

        }else{
            $interpretation_code       = 'N';
            $interpretation_display    = "Normal";
        }
        if(empty($user)){
            return response()->json([
                'status_code'   => 404,
                'message'       => 'User Not Found'
            ],404);
        }

        $data         = [
            'value'         => $value_periksa,
            'unit'          => "Kg/M2",
            'id_pasien'     => $id_pasien,
            'id_petugas'    => $id_pemeriksa,
            'atm_sehat'     => [
                'code_kit'  => $id_kit
            ],
            'time'          => time(),
            'coding'        => [
                'code'      => $find_bmi->code,
                'display'   => $find_bmi->display,
                'system'    => $find_bmi->system
            ],
            'category'      => $category,
            'base_line'     => [
                'min'       => (float) $value_min,
                'max'       => (float) $value_max
            ],
            'interpretation'=> [
                'code'      => $interpretation_code,
                'display'   => $interpretation_display,
                'system'    => 'http://terminology.hl7.org/CodeSystem/v3-ObservationInterpretation'
            ]
        ];
        $observation        = new Observation();
        $create             = $observation->create($data);
        if($create)
        {
            return response()->json([
                'status_code'   => 201,
                'message'       => 'success',
                'data'          => [
                    'glucose'   => $data
                ]

            ]);
        }
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
    private function save($value, $unit=NULL, $id_pasien, $observation_code, $category_code, $base_line, $interpretation){
        $find_category = Code::where('code',$category_code)->first();
        $category       = [
            'code'      => $find_category->code,
            'display'   => $find_category->display,
            'system'    => $find_category->system
        ];
        $find_observasi = Code::where('code', $observation_code)->first();
        $coding_observasi   = [
            'code'      => $find_observasi->code,
            'display'   => $find_observasi->display,
            'system'    => $find_observasi->system
        ];
        $pasien         = User::find($id_pasien);
        $atm_sehat_code = Auth::user()['kit']['kit_code'];
        $atm_sehat      = Kit::where('code', $atm_sehat_code)->first();
        $data_atm_sehat = [
            'code'      => $atm_sehat->code,
            'name'      => $atm_sehat->name,
            'owner'     => $atm_sehat->owner
        ];
        if(empty($pasien)){
            return response()->json([
                'status_code'   => 404,
                'message'       => 'User Not Found'
            ],404);
        }else{
            $data         = [
                'value'         => $value,
                'unit'          => $unit,
                'id_pasien'     => $id_pasien,
                'id_petugas'    => Auth::id(),
                'atm_sehat'     => $data_atm_sehat,
                'time'          => time(),
                'coding'        => $coding_observasi,
                'category'      => $category,
                'base_line'     => $base_line,
                'interpretation'=> $interpretation
            ];
            $observation        = new Observation();
            $create             = $observation->create($data);
            if($create)
            {
                return response()->json([
                    'status_code'   => 201,
                    'message'       => 'success',
                    'data'          => [
                        'glucose'   => $data
                    ]

                ]);
            }else{
                return response()->json([
                    'status_code'   => 400,
                    'message'       => 'Gagal menyimpan data',
                    'data'          => [
                        'glucose'   => $data
                    ]

                ]);
            }
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
