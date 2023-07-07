<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ObservationResource;
use App\Models\Observation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HealthOverViewController extends Controller
{
    public function resume(){
        $tanggal_lahir = Auth::user()['lahir']['tanggal'];
        $birthDate = new \DateTime($tanggal_lahir);
        $today  = new \DateTime("today");
        $y      = $today->diff($birthDate)->y;
        $m      = $today->diff($birthDate)->m;
        $d      = $today->diff($birthDate)->d;
        $usia   = [
            'tahun'         => $y,
            'bulan'         => $m,
            'hari'          => $d
        ];
        $code_sistole   = "8480-6";
        $code_diastolic = "8462-4";
        $hr_code        = "8867-4";
        $body_temp_code = "8310-5";
        $body_weight_code   = "29463-7";
        $code_height    = "8302-2";
        $code_spo2      = "59408-5";
        $code_glucose   = "2345-7";
        $code_chole     = "2093-3";
        $code_UA        = "3084-1";
        $bmi_code       = "39156-5";
        return response()->json([
            'status_code'   => 200,
            'message'       => 'success',
            'data'          => [
                'today'             => $today,
                'gender'            => Auth::user()['gender'],
                'usia'              => $usia,
                'systole'           => $this->myObservation($code_sistole, 1)->original,
                'diastole'          => $this->myObservation($code_diastolic, 1)->original,
                'hearth_rate'       => $this->myObservation($hr_code, 1)->original,
                'body_temperature'  => $this->myObservation($body_temp_code, 1)->original,
                'body_weight'       => $this->myObservation($body_weight_code, 1)->original,
                'body_height'       => $this->myObservation($code_height, 1)->original,
                'oxygen_saturation' => $this->myObservation($code_spo2, 1)->original,
                'blood_glucose'     => $this->myObservation($code_glucose, 1)->original,
                'blood_cholesterole'=> $this->myObservation($code_chole, 1)->original,
                'uric_acid'         => $this->myObservation($code_UA, 1)->original,
                'bmi'               => $this->myObservation($bmi_code, 1)->original
            ]
        ]);
    }

    public function latest(){

        $code_sistole   = "8480-6";
        $code_diastolic = "8462-4";
        $hr_code        = "8867-4";
        $body_temp_code = "8310-5";
        $body_weight_code   = "29463-7";
        $code_height    = "8302-2";
        $code_spo2      = "59408-5";
        $code_glucose   = "2345-7";
        $code_chole     = "2093-3";
        $code_UA        = "3084-1";
        $bmi_code       = "39156-5";
        $family         = User::where('family.id_induk', Auth::id());
        $count          = $family->count();
        $id_pasien      = Auth::id();
        $data = [
            'systole'           => $this->lates($code_sistole, $id_pasien)->getOriginalContent(),
            'diastole'          => $this->lates($code_diastolic, $id_pasien)->getOriginalContent(),
            'hearth_rate'       => $this->lates($hr_code, $id_pasien)->getOriginalContent(),
            'body_temperature'  => $this->lates($body_temp_code, $id_pasien)->getOriginalContent(),
            'body_weight'       => $this->lates($body_weight_code, $id_pasien)->getOriginalContent(),
            'body_height'       => $this->lates($code_height, $id_pasien)->getOriginalContent(),
            'oxygen_saturation' => $this->lates($code_spo2, $id_pasien)->getOriginalContent(),
            'blood_glucose'     => $this->lates($code_glucose, $id_pasien)->getOriginalContent(),
            'blood_cholesterole'=> $this->lates($code_chole, $id_pasien)->getOriginalContent(),
            'uric_acid'         => $this->lates($code_UA, $id_pasien)->getOriginalContent(),
            'bmi'               => $this->lates($bmi_code, $id_pasien)->getOriginalContent(),
        ];

        return response()->json([
            'status_code'   => 200,
            'message'       => 'success',
            'data'          => $data

        ]);
    }
    public function child_observation_latest(Request $request){
        $body_weight_code   = "29463-7";
        $code_height        = "8302-2";
        $family             = User::where('family.id_induk', Auth::id());
        $count              = $family->count();
        $id_pasien          = $request->id_anak;
        $data = [
            'status_gizi'   => $this->lates($body_weight_code, $id_pasien)->getOriginalContent(),
            'stunting'      => $this->lates($code_height, $id_pasien)->getOriginalContent(),
        ];

        return response()->json([
            'status_code'   => 200,
            'message'       => 'success',
            'data'          => $data

        ]);
    }
    public function systole(Request $request){
        $limit          = $request->limit;
        $code_sistole   = "8480-6";
        $systole        = $this->myObservation($code_sistole, $limit);
        return response()->json([
            'status_code'   => 200,
            'message'       => 'success',
            'data'          => [
                'systole'   => $systole->original
            ]
        ],200);
    }
    public function diastole(Request $request){
        $limit          = $request->limit;
        $code_diastolic = "8462-4";
        $diastole       = $this->myObservation($code_diastolic, $limit);
        return response()->json([
            'status_code'   => 200,
            'message'       => 'success',
            'data'          => [
                'diastole'   => $diastole->original
            ]
        ],200);
    }
    public function hearth_rate(Request $request){
        $limit          = $request->limit;
        $code_HR        = '8867-4';
        $hearth_rate    = $this->myObservation($code_HR, $limit);
        return response()->json([
            'status_code'   => 200,
            'message'       => 'success',
            'data'          => [
                'hearth_rate'   => $hearth_rate->original
            ]
        ],200);
    }
    public function temperature(Request $request){
        $limit          = $request->limit;
        $code_suhu      = (string) '8310-5';
        $temperature    = $this->myObservation($code_suhu, $limit);
        return response()->json([
            'status_code'   => 200,
            'message'       => 'success',
            'data'          => [
                'temperature'   => $temperature->original
            ]
        ],200);
    }
    public function spo2(Request $request){
        $limit          = $request->limit;
        $code_spo2      = "59408-5";
        $spo2           = $this->myObservation($code_spo2, $limit);
        return response()->json([
            'status_code'   => 200,
            'message'       => 'success',
            'data'          => [
                'spo2'   => $spo2->original
            ]
        ],200);
    }
    public function weight(Request $request){
        $limit          = $request->limit;
        $weight_code    = "29463-7";
        $weight           = $this->myObservation($weight_code, $limit);
        return response()->json([
            'status_code'   => 200,
            'message'       => 'success',
            'data'          => [
                'weight'   => $weight->original
            ]
        ],200);
    }
    public function height(Request $request){
        $limit          = $request->limit;
        $code_height    = "8302-2";
        $height         = $this->myObservation($code_height, $limit);
        return response()->json([
            'status_code'   => 200,
            'message'       => 'success',
            'data'          => [
                'height'   => $height->original
            ]
        ],200);
    }
    public function bmi(Request $request){
        $limit          = $request->limit;
        $code_bmi       = "39156-5";
        $height         = $this->myObservation($code_bmi, $limit);
        return response()->json([
            'status_code'   => 200,
            'message'       => 'success',
            'data'          => [
                'bmi'   => $height->original
            ]
        ],200);
    }
    public function cholesterol(Request $request){
        $limit          = $request->limit;
        $code_chole     = "2093-3";
        $cholesterol    = $this->myObservation($code_chole, $limit);
        return response()->json([
            'status_code'   => 200,
            'message'       => 'success',
            'data'          => [
                'cholesterol '   => $cholesterol ->original
            ]
        ],200);
    }
    public function uric_acid(Request $request){
        $limit              = $request->limit;
        $observation_code   = "3084-1";
        $observation        = $this->myObservation($observation_code, $limit);
        return response()->json([
            'status_code'   => 200,
            'message'       => 'success',
            'data'          => [
                'uric_acid'   => $observation->original
            ]
        ],200);
    }
    public function glucose(Request $request){
        $limit              = $request->limit;
        $observation_code   = "2345-7";
        $observation        = $this->myObservation($observation_code, $limit);
        return response()->json([
            'status_code'   => 200,
            'message'       => 'success',
            'data'          => [
                'glucose'   => $observation->original
            ]
        ],200);
    }
    public function stunting(Request $request){
        $height_code    = "8302-2";
        $id_pasien      = $request->id_anak;
        $pasien         = User::where('_id', $id_pasien)->first();
        if(empty($pasien)){
            $data =[
                'status_code'   => 404,
                'message'       => 'ID anak tidak terdaftar'
            ];
            return response()->json($data, 404);
        }elseif (! isset($pasien->family['id_induk'])) {
            $data =[
                'status_code'   => 404,
                'message'       => 'ID anak bukan bagian dari keluarga',
            ];
            return response()->json($data, 404);
        }elseif ($pasien->family['id_induk'] != Auth::id()){
            $data =[
                'status_code'   => 404,
                'message'       => 'ID anak bukan bagian dari keluarga',
            ];
            return response()->json($data, 404);
        }
        $stunting       = $this->child_observation($height_code, $id_pasien, $request->limit)->getOriginalContent();
        $data = [
            'status_code'   => 200,
            'message'       => 'success',
            'data'          => [
                'stunting'   => $stunting
            ]
        ];
        return response($data);
    }
    public function status_gizi(Request $request){
        $id_pasien      = $request->id_anak;
        $pasien         = User::where('_id', $id_pasien)->first();
        if(empty($pasien)){
            $data =[
                'status_code'   => 404,
                'message'       => 'ID anak tidak terdaftar'
            ];
            return response()->json($data, 404);
        }elseif (! isset($pasien->family['id_induk'])) {
            $data =[
                'status_code'   => 404,
                'message'       => 'ID anak bukan bagian dari keluarga',
            ];
            return response()->json($data, 404);
        }elseif ($pasien->family['id_induk'] != Auth::id()){
            $data =[
                'status_code'   => 404,
                'message'       => 'ID anak bukan bagian dari keluarga',
            ];
            return response()->json($data, 404);
        }
        $weight_code    = "29463-7";
        $status_gizi    = $this->child_observation($weight_code, $id_pasien, $request->limit)->getOriginalContent();
        $data = [
            'status_code'   => 200,
            'message'       => 'success',
            'data'          => [
                'status_gizi'   => $status_gizi
            ]
        ];
        return response()->json($data, 200);
    }
    private function child_observation($code,$id_pasien,$limit=1){
        $data_observation = Observation::where([
            'id_pasien'             => $id_pasien,
            'pasien.parent.id_induk'=> Auth::id(),
            'coding.code'           => $code
        ])->where('pasien.usia.tahun', "<", 6)->orderBy('time', 'DESC')->limit($limit)->get();
        $observation = ObservationResource::collection($data_observation);
        return response($observation);
    }
    public function observation(Request $request){
        $paginate       = $request->header('paginate');
        $observation    = Observation::where('id_pasien', Auth::id())->orWhere('pasien.parent.id_induk', Auth::id())->orderBy('time', 'DESC')->paginate($paginate);
        return response()->json([
            'status_code'   => 200,
            'message'       => 'success',
            'data'          => [
                'observations'   => ObservationResource::collection($observation)
            ]
        ],200);
    }
    private function myObservation($observation_code, $limit=1){
        $query_ovsrevation = Observation::where([
            'coding.code'   => $observation_code,
            'id_pasien'     => Auth::id()
        ])->orderBy('time', 'DESC')->limit($limit)->get();
        $myObservation  = ObservationResource::collection($query_ovsrevation);

        return response($myObservation);
    }
    private function lates($observation_code, $id_pasien){
        $myObservation  = Observation::where([
            'coding.code'   => $observation_code,
            'id_pasien'     => $id_pasien
        ])->latest()->first();

        return response($myObservation);
    }
    private function usia($tanggal_lahir){
        $birthDate  = new \DateTime($tanggal_lahir);
        $today      = new \DateTime("today");
        $y          = $today->diff($birthDate)->y;
        $m          = $today->diff($birthDate)->m;
        $d          = $today->diff($birthDate)->d;
        $usia       = [
            'tahun'         => $y,
            'bulan'         => $m,
            'hari'          => $d
        ];
        return response($usia);
    }
}
