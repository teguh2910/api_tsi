<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Observation\UpdateObservationRequest;
use App\Http\Resources\ObservationResource;
use App\Models\BaseLine;
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
                    'observasi' => ObservationResource::collection($query)
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
        $observation = ObservationResource::collection($query_observasi->orderBy($order_by, $sort)->paginate($request->paginate)) ;
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
        $validator      = Validator::make($request->all(), [
            'systolic'      => 'required|numeric|min:40|max:300',
            'diastolic'     => 'required|numeric|min:10|max:200',
            'heart_rate'    => 'required|numeric|min:10|max:500',
            'id_pasien'     => 'required'
        ]);
        $id_pasien          = $request->id_pasien;
        $pasien             = User::where('_id',$id_pasien)->first();

        if($validator->fails()){
            return response()->json([
                'status_code'   => 422,
                'message'       => 'gagal validasi',
                'data'          => [
                    "errors"    => $validator->errors()
                ]

            ],422);
        }else if(empty($pasien)){
            return response()->json([
                'status_code'   => 404,
                'message'       => 'Pasien Tidak Ditemukan',
                'data'          => [
                    "pasien"    => $pasien
                ]

            ],404);
        }
        $save_systole = $this->systolic_private($request->systolic, $request->id_pasien);
        $data_sytole = [
            'status_code'   => $save_systole->original['status_code'],
            'message'       => $save_systole->original['message'],
            'data'          => $save_systole->original['data']
        ];
        $save_diastole = $this->diastolic_private($request->diastolic, $request->id_pasien);
        $data_diastole = [
            'status_code'   => $save_diastole->original['status_code'],
            'message'       => $save_diastole->original['message'],
            'data'          => $save_diastole->original['data']
        ];
        $save_hr = $this->nadi_private($request->heart_rate, $request->id_pasien);
        $data_hr = [
            'status_code'   => $save_hr->original['status_code'],
            'message'       => $save_hr->original['message'],
            'data'          => $save_hr->original['data']
        ];
        return response()->json([
            'status_code'   => '200',
            'message'       => 'success',
            'data'          => [
                'data_systole'  => $data_sytole['data']['observation'],
                'data_diastole' => $data_diastole['data']['observation'],
                'data_hr'       => $data_hr['data']['observation']
            ]
        ]);

    }

    public function hearth_rate(Request $request){
        $id_pasien          = $request->id_pasien;
        $pasien             = User::where('_id',$id_pasien)->first();
        $validator      = Validator::make($request->all(), [
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
        }elseif (empty($pasien)){
            return response()->json([
                'status_code'   => 404,
                'message'       => 'Pasien tidak ditemukan',
                'data'          => [
                    "pasien"    => $pasien
                ]
            ],404);
        }
        $save = $this->nadi_private($request->heart_rate, $request->id_pasien);
        return response()->json($save->original, $save->original['status_code']);
    }
    public function systole(Request $request){
        $validator      = Validator::make($request->all(), [
            'systolic'    => 'required|numeric|min:10|max:300',
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
        $save = $this->systolic_private($request->systolic, $request->id_pasien);
        return response()->json($save->original, $save->original['status_code']);
    }
    public function diastole(Request $request){
        $validator      = Validator::make($request->all(), [
            'diastolic'     => 'required|numeric|min:10|max:200',
            'id_pasien'     => 'required'
        ]);
        if($request->diastolic < 10 or $request->diastolic > 200){
            return response()->json([
                'status_code'   => 422,
                'message'       => 'nilai diastolic bernilai antara 11-199',
                'data'          => [
                    "errors"    => $validator->errors()
                ]
            ],422);
        }
        if($validator->fails()){
            return response()->json([
                'status_code'   => 422,
                'message'       => 'gagal validasi',
                'data'          => [
                    "errors"    => $validator->errors()
                ]
            ],422);
        }
        $save = $this->diastolic_private($request->diastolic, $request->id_pasien);
        return response()->json($save->original, $save->original['status_code']);
    }
    public function temperature(Request $request)
    {
        $validator      = Validator::make($request->all(), [
            'suhu'      => 'required|numeric|min:35|max:45',
            'id_pasien' => 'required'
        ]);
        if($request->suhu < 35 or $request->suhu > 43){
            return response()->json([
                'status_code'   => 422,
                'message'       => 'nilai suhu harus bernilai antara 35.00-42.9',
                'data'          => [
                    "errors"    => $validator->errors()
                ]
            ],422);
        }
        if($validator->fails()){
            return response()->json([
                'status_code'   => 422,
                'message'       => 'Gagal Validasi',
                'data'          => [
                    'errors'    => $validator->errors()
                ]
            ],422);
        }
        //mencari data observasi
        $category_code      = 'vital-signs';
        $observation_code   = (string) '8310-5';
        $unit               = [
            'code'      => 'C',
            'display'   => 'C',
            'system'    => 'http://unitsofmeasure.org'
        ];
        $id_pasien      = $request->id_pasien;
        $value_periksa  = (float) $request->suhu;
        $value_min      = 36;
        $value_max      = 37.5;
        $base_line          = [
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

        $save = $this->save($value_periksa, $unit, $id_pasien, $observation_code, $category_code, $base_line, $interpretation);
        return response()->json($save->original, $save->original['status_code']);

    }
    public function weight(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'weight'    => 'required|numeric|min:1|max:300',
            'id_pasien' => 'required'
        ]);
        $id_pasien          = $request->id_pasien;
        $pasien             = User::where('_id',$id_pasien)->first();
        $category_code      = 'vital-signs';
        $observation_code   = "29463-7";
        if($request->weight < 1 or $request->weight > 300){
            return response()->json([
                'status_code'   => 422,
                'message'       => 'nilai berat badan harus bernilai antara 1.00-299.9',
                'data'          => [
                    "errors"    => $validation->errors()
                ]
            ],422);
        }
        if($validation->fails())
        {
            return response()->json([
                'status_code'   => 422,
                'message'       => 'Gagal validasi',
                'content'       => $validation->errors()
            ],422);
        }else if(empty($pasien )){
            return response()->json([
                'status_code'   => 404,
                'message'       => 'Pasien Tidak ditemukan',
                'data'          => [
                    'pasien'    => $pasien
                ]
            ],404);
        }else{
            $tanggal_lahir      = $pasien->lahir['tanggal'];
            $birthDate          = new \DateTime($tanggal_lahir);
            $today              = new \DateTime("today");
            $y                  = $today->diff($birthDate)->y;
            $m                  = $today->diff($birthDate)->m;
            $d                  = $today->diff($birthDate)->d;
            $usia               = [
                'tahun'         => $y,
                'bulan'         => $m,
                'hari'          => $d
            ];
            if($y<1){
                $usia = $m;
            }else{
                $usia = ($y*12)+$m;
            }
            $variabel           = ucwords($pasien->gender);
            $variabel_1         = "Usia";
            $nilai_variabel_1   = (string) $usia;
            $variabel_2         = "Berat Badan";
            $value_periksa      = (float) $request->weight;
            if($usia<=60){
                $median             = $this->base_line_status_gizi($variabel, $variabel_1, $nilai_variabel_1, $variabel_2, "0" )->getOriginalContent();
                $sd_1               = $this->base_line_status_gizi($variabel, $variabel_1, $nilai_variabel_1, $variabel_2, "1" )->getOriginalContent();
                $sd_2               = $this->base_line_status_gizi($variabel, $variabel_1, $nilai_variabel_1, $variabel_2, "2" )->getOriginalContent();
                $sd_3               = $this->base_line_status_gizi($variabel, $variabel_1, $nilai_variabel_1, $variabel_2, "3" )->getOriginalContent();
                $sd_1_min           = $this->base_line_status_gizi($variabel, $variabel_1, $nilai_variabel_1, $variabel_2, "-1" )->getOriginalContent();
                $sd_2_min           = $this->base_line_status_gizi($variabel, $variabel_1, $nilai_variabel_1, $variabel_2, "-2" )->getOriginalContent();
                $sd_3_min           = $this->base_line_status_gizi($variabel, $variabel_1, $nilai_variabel_1, $variabel_2, "-3" )->getOriginalContent();
                $base_line          = [
                    '-3SD'      => $sd_3_min->nilai_variabel_2,
                    '-2SD'      => $sd_2_min->nilai_variabel_2,
                    '-1SD'      => $sd_1_min->nilai_variabel_2,
                    'median'    => $median->nilai_variabel_2,
                    '+1SD'      => $sd_1->nilai_variabel_2,
                    '+2SD'      => $sd_2->nilai_variabel_2,
                    '+3SD'      => $sd_3->nilai_variabel_2,
                ];
                if($value_periksa < $sd_3_min->nilai_variabel_2){
                    $interpretation     = [
                        'code'      => "<-3SD",
                        'display'   => "Berat badan sangat kurang",
                        'system'    => 'PERATURAN MENTERI KESEHATAN REPUBLIK INDONESIA NOMOR 2 TAHUN 2020 TENTANG STANDAR ANTROPOMETRI ANAK'
                    ];
                }else if($value_periksa < $sd_2_min->nilai_variabel_2){
                    $interpretation     = [
                        'code'      => "<-2SD",
                        'display'   => "Berat badan kurang",
                        'system'    => 'PERATURAN MENTERI KESEHATAN REPUBLIK INDONESIA NOMOR 2 TAHUN 2020 TENTANG STANDAR ANTROPOMETRI ANAK'
                    ];

                }else if($value_periksa < $sd_1_min->nilai_variabel_2){
                    $interpretation     = [
                        'code'      => "<-1SD",
                        'display'   => "Berat badan normal",
                        'system'    => 'PERATURAN MENTERI KESEHATAN REPUBLIK INDONESIA NOMOR 2 TAHUN 2020 TENTANG STANDAR ANTROPOMETRI ANAK'
                    ];
                }else if($value_periksa < $median->nilai_variabel_2){
                    $interpretation     = [
                        'code'      => "< Median",
                        'display'   => "Berat badan normal",
                        'system'    => 'PERATURAN MENTERI KESEHATAN REPUBLIK INDONESIA NOMOR 2 TAHUN 2020 TENTANG STANDAR ANTROPOMETRI ANAK'
                    ];

                }else if($value_periksa < $sd_1->nilai_variabel_2){
                    $interpretation     = [
                        'code'      => "<+1SD",
                        'display'   => "Berat badan normal",
                        'system'    => 'PERATURAN MENTERI KESEHATAN REPUBLIK INDONESIA NOMOR 2 TAHUN 2020 TENTANG STANDAR ANTROPOMETRI ANAK'
                    ];
                }else if($value_periksa < $sd_2->nilai_variabel_2){
                    $interpretation     = [
                        'code'      => "<+2SD",
                        'display'   => "Risiko Berat badan lebih",
                        'system'    => 'PERATURAN MENTERI KESEHATAN REPUBLIK INDONESIA NOMOR 2 TAHUN 2020 TENTANG STANDAR ANTROPOMETRI ANAK'
                    ];
                }else if($value_periksa < $sd_3->nilai_variabel_2){
                    $interpretation     = [
                        'code'      => "<+3SD",
                        'display'   => "Risiko Berat badan lebih",
                        'system'    => 'PERATURAN MENTERI KESEHATAN REPUBLIK INDONESIA NOMOR 2 TAHUN 2020 TENTANG STANDAR ANTROPOMETRI ANAK'
                    ];
                }else{
                    $interpretation     = [
                        'code'      => "+3SD",
                        'display'   => "Risiko Berat badan lebih",
                        'system'    => 'PERATURAN MENTERI KESEHATAN REPUBLIK INDONESIA NOMOR 2 TAHUN 2020 TENTANG STANDAR ANTROPOMETRI ANAK'
                    ];
                }
            }else{
                $base_line = NULL;
                $interpretation = NULL;
            }
            $unit           = [
                'code'      => 'Kg',
                'display'   => 'Kg',
                'system'    => 'http://unitsofmeasure.org'
            ];
            $save = $this->save($value_periksa, $unit, $id_pasien, $observation_code, $category_code, $base_line, $interpretation);
            return response()->json($save->original, $save->original['status_code']);
        }
    }
    public function height(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'height'    => 'required|numeric|min:40|max:250',
            'id_pasien' => 'required'
        ]);
        $id_pasien          = $request->id_pasien;
        $pasien             = User::where('_id',$id_pasien)->first();
        if($request->height < 40 or $request->height > 250){
            return response()->json([
                'status_code'   => 422,
                'message'       => 'nilai berat badan harus bernilai antara 1.00-299.9',
                'data'          => [
                    "errors"    => $validation->errors()
                ]
            ],422);
        }
        if($validation->fails())
        {
            return response()->json([
                'status_code'   => 422,
                'message'       => 'Gagal validasi',
                'data'          => [
                    'errors'    => $validation->errors()
                ]
            ],422);
        }elseif(empty($pasien)){
            return response()->json([
                'status_code'   => 404,
                'message'       => 'Pasien Tidak ditemukan',
                'data'          => [
                    'pasien'    => $pasien
                ]
            ],404);
        }
        $category_code      = 'vital-signs';
        $observation_code   = "8302-2";
        $weight_code        = "29463-7";
        $umur               = $this->usia($pasien->lahir['tanggal'])->getOriginalContent();

        if($umur['tahun']<1){
            $usia = $umur['bulan'];
        }else{
            $usia = ($umur['tahun']*12)+$umur['bulan'];
        }
        $weight             = Observation::where([
            'id_pasien'     => $id_pasien,
            'coding.code'   => $weight_code
        ]);
        if($weight->count() > 0){
            $data_weight    = $weight->orderBy('time', 'DESC')->limit(1)->get();
            $berat_badan    = (float) $data_weight[0]['value'];
            $tinggi_badan   = (float) $request->height;
            $create_bmi     = $this->bmi($berat_badan, $tinggi_badan, $id_pasien);
        }
        $value_periksa      = (float) $request->height;
        if($usia<=60){
            $variabel           = ucwords($pasien->gender);
            $variabel_1         = "Usia";
            $nilai_variabel_1   = (string)$usia;
            if($usia<24){
                $variabel_2     = "Panjang Badan";
            }else{
                $variabel_2     = "Tinggi Badan";
            }
            $median             = $this->base_line_status_gizi($variabel, $variabel_1, $nilai_variabel_1, $variabel_2, "0" )->getOriginalContent();
            $sd_1               = $this->base_line_status_gizi($variabel, $variabel_1, $nilai_variabel_1, $variabel_2, "1" )->getOriginalContent();
            $sd_2               = $this->base_line_status_gizi($variabel, $variabel_1, $nilai_variabel_1, $variabel_2, "2" )->getOriginalContent();
            $sd_3               = $this->base_line_status_gizi($variabel, $variabel_1, $nilai_variabel_1, $variabel_2, "3" )->getOriginalContent();
            $sd_1_min           = $this->base_line_status_gizi($variabel, $variabel_1, $nilai_variabel_1, $variabel_2, "-1" )->getOriginalContent();
            $sd_2_min           = $this->base_line_status_gizi($variabel, $variabel_1, $nilai_variabel_1, $variabel_2, "-2" )->getOriginalContent();
            $sd_3_min           = $this->base_line_status_gizi($variabel, $variabel_1, $nilai_variabel_1, $variabel_2, "-3" )->getOriginalContent();
            $base_line          = [
                '-3SD'      => (float) $sd_3_min->nilai_variabel_2,
                '-2SD'      => (float) $sd_2_min->nilai_variabel_2,
                '-1SD'      => (float) $sd_1_min->nilai_variabel_2,
                'median'    => (float) $median->nilai_variabel_2,
                '+1SD'      => (float) $sd_1->nilai_variabel_2,
                '+2SD'      => (float) $sd_2->nilai_variabel_2,
                '+3SD'      => (float) $sd_3->nilai_variabel_2,
            ];
            if($value_periksa < $sd_3_min->nilai_variabel_2){
                $interpretation     = [
                    'code'      => "<-3SD",
                    'display'   => "Sangat pendek",
                    'system'    => 'PERATURAN MENTERI KESEHATAN REPUBLIK INDONESIA NOMOR 2 TAHUN 2020 TENTANG STANDAR ANTROPOMETRI ANAK'
                ];
            }else if($value_periksa < $sd_2_min->nilai_variabel_2){
                $interpretation     = [
                    'code'      => "<-2SD",
                    'display'   => "Pendek",
                    'system'    => 'PERATURAN MENTERI KESEHATAN REPUBLIK INDONESIA NOMOR 2 TAHUN 2020 TENTANG STANDAR ANTROPOMETRI ANAK'
                ];

            }else if($value_periksa < $sd_1_min->nilai_variabel_2){
                $interpretation     = [
                    'code'      => "<-1SD",
                    'display'   => "Normal",
                    'system'    => 'PERATURAN MENTERI KESEHATAN REPUBLIK INDONESIA NOMOR 2 TAHUN 2020 TENTANG STANDAR ANTROPOMETRI ANAK'
                ];

            }else if($value_periksa < $median->nilai_variabel_2){
                $interpretation     = [
                    'code'      => "< Median",
                    'display'   => "Normal",
                    'system'    => 'PERATURAN MENTERI KESEHATAN REPUBLIK INDONESIA NOMOR 2 TAHUN 2020 TENTANG STANDAR ANTROPOMETRI ANAK'
                ];

            }else if($value_periksa < $sd_1->nilai_variabel_2){
                $interpretation     = [
                    'code'      => "<+1SD",
                    'display'   => "Normal",
                    'system'    => 'PERATURAN MENTERI KESEHATAN REPUBLIK INDONESIA NOMOR 2 TAHUN 2020 TENTANG STANDAR ANTROPOMETRI ANAK'
                ];

            }else if($value_periksa < $sd_2->nilai_variabel_2){
                $interpretation     = [
                    'code'      => "<+2SD",
                    'display'   => "Normal",
                    'system'    => 'PERATURAN MENTERI KESEHATAN REPUBLIK INDONESIA NOMOR 2 TAHUN 2020 TENTANG STANDAR ANTROPOMETRI ANAK'
                ];

            }else if($value_periksa < $sd_3->nilai_variabel_2){
                $interpretation     = [
                    'code'      => "<+3SD",
                    'display'   => "Normal",
                    'system'    => 'PERATURAN MENTERI KESEHATAN REPUBLIK INDONESIA NOMOR 2 TAHUN 2020 TENTANG STANDAR ANTROPOMETRI ANAK'
                ];
            }else{
                $interpretation     = [
                    'code'      => "+3SD",
                    'display'   => "Tinggi",
                    'system'    => 'PERATURAN MENTERI KESEHATAN REPUBLIK INDONESIA NOMOR 2 TAHUN 2020 TENTANG STANDAR ANTROPOMETRI ANAK'
                ];
            }

        }else{
            $base_line = NULL;
            $interpretation = NULL;
        }

        $unit               = [
            'code'      => 'cm',
            'display'   => 'cm',
            'system'    => 'http://unitsofmeasure.org'
        ];
        $save = $this->save($value_periksa, $unit, $id_pasien, $observation_code, $category_code, $base_line, $interpretation);
        return response()->json($save->original, $save->original['status_code']);

    }
    public function spo2(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'spo2'      => 'required|numeric|min:40|max:100',
            'id_pasien' => 'required'
        ]);
        $id_pasien          = $request->id_pasien;
        $pasien             = User::where('_id',$id_pasien)->first();
        if($validation->fails())
        {
            return response()->json([
                'status_code'   => 422,
                'message'       => 'Gagal validasi',
                'data'          => [
                    'errors'    => $validation->errors()
                ]
            ],422);
        }elseif(empty($pasien)){
            return response()->json([
                'status_code'   => 404,
                'message'       => 'Pasien Tidak ditemukan',
                'data'          => [
                    'pasien'    => $pasien
                ]
            ],404);
        }
        $category_code      = 'vital-signs';
        $observation_code   = "59408-5";
        $id_pasien          = $request->id_pasien;
        $value_periksa      = (float) $request->spo2;
        $value_min          = 95;
        $value_max          = 100;
        $base_line          = [
            'min'       => $value_min,
            'max'       => $value_max
        ];
        $unit               = [
            'code'      => '%',
            'display'   => '%',
            'system'    => 'http://unitsofmeasure.org'
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
        $save = $this->save($value_periksa, $unit, $id_pasien, $observation_code, $category_code, $base_line, $interpretation);
        return response()->json($save->original, $save->original['status_code']);


    }
    public function uric_acid(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'uric_acid'     => 'required|numeric|min:1|max:100',
            'id_pasien'     => 'required'
        ]);
        $id_pasien          = $request->id_pasien;
        $pasien             = User::where('_id',$id_pasien)->first();
        if($validation->fails())
        {
            return response()->json([
                'status_code'   => 422,
                'message'       => 'Gagal validasi',
                'data'          => [
                    'errors'    => $validation->errors()
                ]
            ],422);
        }elseif(empty($pasien)){
            return response()->json([
                'status_code'   => 404,
                'message'       => 'Pasien Tidak ditemukan',
                'data'          => [
                    'pasien'    => $pasien
                ]
            ],404);
        }
        $category_code      = 'laboratory'; //untuk category
        $observation_code   = "3084-1";     //untuk asam urat
        $id_pasien          = $request->id_pasien;
        $value_periksa      = (float) $request->uric_acid;
        $unit               = [
            'code'      => 'mg/dL',
            'display'   => 'mg/dL',
            'system'    => 'http://unitsofmeasure.org'
        ];
        $value_min          = 3.4;
        $value_max          = 7.0;
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
        $save = $this->save($value_periksa, $unit, $id_pasien, $observation_code, $category_code, $base_line, $interpretation);
        return response()->json($save->original, $save->original['status_code']);
    }
    public function cholesterol(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'cholesterol'   => 'required|numeric|min:10|max:600',
            'id_pasien'     => 'required'
        ]);
        $id_pasien          = $request->id_pasien;
        $pasien             = User::where('_id',$id_pasien)->first();
        if($validation->fails())
        {
            return response()->json([
                'status_code'   => 422,
                'message'       => 'Gagal validasi',
                'data'          => [
                    'errors'    => $validation->errors()
                ]
            ],422);
        }elseif(empty($pasien)){
            return response()->json([
                'status_code'   => 404,
                'message'       => 'Pasien Tidak ditemukan',
                'data'          => [
                    'pasien'    => $pasien
                ]
            ],404);
        }
        $category_code      = 'laboratory';
        $observation_code   = "2093-3";
        $value_periksa      = (float) $request->cholesterol;
        $value_min      = 125;
        $value_max      = 200;
        $base_line      = [
            'min'       => $value_min,
            'max'       => $value_max
        ];
        $unit               = [
            'code'      => 'mg/dL',
            'display'   => 'mg/dL',
            'system'    => 'http://unitsofmeasure.org'
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
        $save = $this->save($value_periksa, $unit, $id_pasien, $observation_code, $category_code, $base_line, $interpretation);
        return response()->json($save->original, $save->original['status_code']);



    }
    public function blood_glucose(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'glucose'       => 'required|numeric|min:10|max:600',
            'id_pasien'     => 'required'
        ]);
        $id_pasien          = $request->id_pasien;
        $pasien             = User::where('_id',$id_pasien)->first();
        if($validation->fails())
        {
            return response()->json([
                'status_code'   => 422,
                'message'       => 'Gagal validasi',
                'data'          => [
                    'errors'    => $validation->errors()
                ]
            ],422);
        }elseif(empty($pasien)){
            return response()->json([
                'status_code'   => 404,
                'message'       => 'Pasien Tidak ditemukan',
                'data'          => [
                    'pasien'    => $pasien
                ]
            ],404);
        }
        $category_code = 'laboratory';
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
        $save = $this->save($value_periksa, $unit, $id_pasien, $code_glucose, $category_code, $base_line, $interpretation);
        return response()->json($save->original, $save->original['status_code']);
    }
    public function gd(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'glucose'       => 'required|numeric|min:10|max:600',
            'id_pasien'     => 'required'
        ]);
        $id_pasien          = $request->id_pasien;
        $pasien             = User::where('_id',$id_pasien)->first();
        if($validation->fails())
        {
            return response()->json([
                'status_code'   => 422,
                'message'       => 'Gagal validasi',
                'data'          => [
                    'errors'    => $validation->errors()
                ]
            ],422);
        }elseif(empty($pasien)){
            return response()->json([
                'status_code'   => 404,
                'message'       => 'Pasien Tidak ditemukan',
                'data'          => [
                    'pasien'    => $pasien
                ]
            ],404);
        }
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
        $save = $this->save($value_periksa, $unit, $id_pasien, $code_glucose, $category_code, $base_line, $interpretation);
        return response()->json($save->original, $save->original['status_code']);
    }
    private function interpretasi(){

    }
    private function base_line_status_gizi($variabel, $variabel_1, $nilai_variabel_1, $variabel_2="", $label){
        $base_line = BaseLine::where([
            'variabel'          => $variabel,
            'variabel_1'        => $variabel_1,
            'nilai_variabel_1'  => $nilai_variabel_1,
            'variabel_2'        => $variabel_2,
            'label'             => $label
        ])->first();
        return response($base_line);
    }

    private function bmi($berat_badan, $tinggi_badan, $id_pasien){
        $value_periksa      = round($berat_badan/(($tinggi_badan/100)*($tinggi_badan/100)),2) ;
        $unit               = [
            'code'      => 'Kg/M2',
            'display'   => 'Kg/M2',
            'system'    => 'http://unitsofmeasure.org'
        ];
        $category_code      = "vital-signs";
        $observation_code   = "39156-5";
        $value_min          = 18.5;
        $value_max          = 24.9;
        $base_line          = [
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
        $save = $this->save($value_periksa, $unit, $id_pasien, $observation_code, $category_code, $base_line, $interpretation);
        return response()->json($save->original, $save->original['status_code']);
    }
    private function systolic_private($systole, $id_pasien){
        $category_code      = (string) 'vital-signs';
        $observation_code   = (string) '8480-6';
        $min                = 90;
        $max                = 129;
        $base_line          = [
            'min'       => $min,
            'max'       => $max
        ];
        $unit   = [
            'code'      => 'mmHg',
            'display'   => 'mmHg',
            'system'    => 'http://unitsofmeasure.org'
        ];

        if($systole < $min){
            $interpretation_code       = 'L';
            $interpretation_display    = "Low";
        }elseif($systole > $max){
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
        $save = $this->save($systole, $unit, $id_pasien, $observation_code, $category_code, $base_line, $interpretation);
        return response()->json($save->original, $save->original['status_code']);

    }
    private function diastolic_private($diastole, $id_pasien){
        $category_code      = (string) 'vital-signs';
        $observation_code   = (string) '8462-4';
        $min                = 60;
        $max                = 89;
        $base_line          = [
            'min'       => $min,
            'max'       => $max
        ];
        $unit   = [
            'code'      => 'mmHg',
            'display'   => 'mmHg',
            'system'    => 'http://unitsofmeasure.org'
        ];

        if($diastole < $min){
            $interpretation_code       = 'L';
            $interpretation_display    = "Low";
        }elseif($diastole > $max){
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
        $save = $this->save($diastole, $unit, $id_pasien, $observation_code, $category_code, $base_line, $interpretation);
        return response()->json($save->original, $save->original['status_code']);

    }
    private function nadi_private($hearth_rate, $id_pasien){
        $category_code      = (string) 'vital-signs';
        $observation_code   = (string) '8867-4';
        $pasien = User::find($id_pasien);
        $tgl_lahir = $pasien->lahir['tanggal'];
        $usia = $this->usia($tgl_lahir)->getOriginalContent();
        $usia_bulan = ($usia['tahun']*12)+($usia['bulan']);
        if($usia_bulan <= 1 ){
            $min                = 70;
            $max                = 190;
        }elseif ($usia_bulan <= 11){
            $min                = 80;
            $max                = 160;
        }elseif ($usia_bulan <= 24){
            $min                = 80;
            $max                = 130;
        }elseif ($usia_bulan <= 48){
            $min                = 80;
            $max                = 120;
        }elseif ($usia_bulan <= 72){
            $min                = 75;
            $max                = 115;
        }elseif ($usia_bulan <= 108){
            $min                = 70;
            $max                = 110;
        }else{
            $min                = 60;
            $max                = 100;
        }

        $base_line          = [
            'min'       => $min,
            'max'       => $max
        ];
        $unit        = [
            'code'      => 'bpm',
            'display'   => 'beats/minute',
            'system'    => 'http://unitsofmeasure.org'
        ];


        if($hearth_rate < $min){
            $interpretation_code       = 'L';
            $interpretation_display    = "Low";
        }elseif($hearth_rate > $max){
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
        $save = $this->save($hearth_rate, $unit, $id_pasien, $observation_code, $category_code, $base_line, $interpretation);
        return response()->json($save->original, $save->original['status_code']);

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
            $status_code    = 404;
            $message        = "User Not Found";
            $data           = [
                'pasien'    => $pasien
            ];
        }else{
            $data         = [
                'value'         => $value,
                'unit'          => $unit,
                'id_pasien'     => $id_pasien,
                'pasien'        => [
                    'id'        => $pasien->_id,
                    'nama'      => $pasien->nama,
                    'gender'    => $pasien->gender,
                    'nik'       => $pasien->nik,
                    'lahir'     => $pasien->lahir,
                    'usia'      => $this->usia($pasien->lahir['tanggal'])->getOriginalContent(),
                    'parent'    => $pasien->family
                ],
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
                $status_code    = 200;
                $message        = "success";
                $data           = [
                    'observation'   => $data
                ];
            }else{
                $status_code    = 400;
                $message        = "Gagal menyimpan data";
                $data           = [
                    'glucose'   => $data
                ];
                return response()->json([
                    'status_code'   => 400,
                    'message'       => 'Gagal menyimpan data',
                    'data'          => [
                        'observation'   => $data
                    ]
                ]);
            }
            $response   = [
                'status_code'   => $status_code,
                'message'       => $message,
                'data'          => $data
            ];
            return response($response);
        }
    }
    private function user($id){
        $user = User::find($id);
        return response($user);
    }

    public function show($id)
    {
        $observation    = Observation::find($id);
        $status_code    = 200;
        $message        = "success";
        $data           = [
            "observation"   => [
                'name'              => $observation->coding,
                'category'          => $observation->category,
                'value'             => $observation->value,
                'unit'              => $observation->unit,
                'time'              => $observation->time,
                'base_line'         => $observation->base_line,
                'interpretation'    => $observation->interpretation,
                'patient'           => $this->user($observation->id_pasien)->original,
                'observer'          => $this->user($observation->id_petugas)->original
            ]
        ];
        $response       = [
            'status_code'   => $status_code,
            'message'       => $message,
            'data'          => $data
        ];
        return response($response, $status_code);
    }


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

    private function usia($tgl_lahir)
    {
        $birthDate      = new \DateTime($tgl_lahir);
        $today          = new \DateTime("today");
        $y              = $today->diff($birthDate)->y;
        $m              = $today->diff($birthDate)->m;
        $d              = $today->diff($birthDate)->d;
        $usia           = [
            'tahun'         => $y,
            'bulan'         => $m,
            'hari'          => $d
        ];
        return response($usia);
    }
}
