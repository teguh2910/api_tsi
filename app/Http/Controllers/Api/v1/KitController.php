<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Code;
use App\Models\Customer;
use App\Models\Kit;
use App\Models\Log_user_kit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KitController extends Controller
{
    public function index(){
        $kit = Kit::all();
        return response()->json([
            'status_code'   => 200,
            'message'       => 'Success',
            'data'          => [
                'kit'       => $kit
            ]
        ], 200);
    }
    public function show($code){
        $kit    = Kit::where('code', $code)->first();

        if(empty($kit)){
            return response()->json([
                'status_code'   => 404,
                'message'       => 'Not Found',
                'data'          => [
                    'kit'       => $kit
                ]
            ], 404);
        }else if(!isset($kit->pasien['id_pasien'])){
                return response()->json([
                    'status_code'   => 404,
                    'message'       => 'Pasien Not Found',
                    'data'          => [
                        'kit'       => $kit,
                    ]
                ], 404);
            }else{
                $pasien = User::find($kit->pasien['id_pasien']);
                return response()->json([
                    'status_code'   => 200,
                    'message'       => 'Not Found',
                    'data'          => [
                        'kit'       => $kit,
                        'pasien'    => [
                            'id_pasien'     => $pasien->_id,
                            'nama_depan'    => $pasien->nama['nama_depan'],
                            'nama_belakang' => $pasien->nama['nama_belakang'],
                            'gender'        => $pasien->gender,
                            'tempat_lahir'  => $pasien->lahir['tempat'],
                            'tanggal_lahir' => $pasien->lahir['tanggal'],
                            'email'         => $pasien->kontak['email'],
                            'nomor_telepon' => $pasien->kontak['nomor_telepon'],
                        ],
                    ]
                ], 200);
            }
        }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'kit_code'          => 'required|unique:kits,code',
            'kit_name'          => 'required',
            'owner_code'        => 'required',
            'distributor_code'  => 'required'
        ]);

        if($validator->fails()){
            $status_code    = 422;
            $data           = [
                "status_code"   => $status_code,
                "message"       => "gagal Validasi",
                "data"          => [
                    "errors"    => $validator->errors()
                ]
            ];
            return response()->json($data, $status_code);
        }
        $owner          = $this->customer($request->owner_code)->original;
        $distributor    = $this->customer($request->distributor_code)->original;
        $input = [
            'code'          => $request->kit_code,
            'name'          => $request->kit_name,
            'owner'         => [
                'code'      => $owner->code,
                'name'      => $owner->name
            ],
            'distributor'   => [
                'code'      => $distributor->code,
                'name'      => $distributor->name
            ],
            'is_active'     => (bool) true
        ];
        $kit = new Kit();
        $add = $kit->create($input);
        if($add){
            $status_code    = 201;
            $data           = [
                "status_code"   => $status_code,
                "message"       => "success",
                "data"          => [
                    "kit"    => $input
                ]
            ];
            return response()->json($data, $status_code);

        }
    }
    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'kit_code'          => 'required',
            'kit_name'          => 'required',
            'owner_code'        => 'required',
            'distributor_code'  => 'required'
        ]);

        if($validator->fails()){
            $status_code    = 422;
            $data           = [
                "status_code"   => $status_code,
                "message"       => "gagal Validasi",
                "data"          => [
                    "errors"    => $validator->errors()
                ]
            ];
            return response()->json($data, $status_code);
        }
        $kit_code       = $request->kit_code;
        $kit            = Kit::where('code',(string) $kit_code)->first();
        $owner          = $this->customer($request->owner_code)->original;
        $distributor    = $this->customer($request->distributor_code)->original;
        $input = [
            'code'          => $request->kit_code,
            'name'          => $request->kit_name,
            'owner'         => [
                'code'      => $owner->code,
                'name'      => $owner->name
            ],
            'distributor'   => [
                'code'      => $distributor->code,
                'name'      => $distributor->name
            ],
            'is_active'     => (bool) true
        ];
        if(empty($kit)){
            $status_code    = 404;
            $data           = [
                "status_code"   => $status_code,
                "message"       => "Not Found",
                "data"          => [
                    "kit"       => $kit
                ]
            ];
            return response()->json($data, $status_code);
        }
        $update = $kit->update($input);
        if($update){
            $status_code    = 200;
            $data           = [
                "status_code"   => $status_code,
                "message"       => "success",
                "data"          => [
                    "kit"    => $input
                ]
            ];
            return response()->json($data, $status_code);
        }
    }
    public function destroy(Request $request){
        $validator = Validator::make($request->all(), [
            'kit_code'          => 'required',
        ]);
        $kit_code       = $request->kit_code;
        $kit            = Kit::where('code',(string) $kit_code)->first();

        if($validator->fails()){
            $status_code    = 422;
            $data           = [
                "status_code"   => $status_code,
                "message"       => "gagal Validasi",
                "data"          => [
                    "errors"    => $validator->errors()
                ]
            ];
            return response()->json($data, $status_code);
        }elseif(empty($kit)){
            $status_code    = 404;
            $data           = [
                "status_code"   => $status_code,
                "message"       => "Not Found",
                "data"          => [
                    "kit"       => $kit
                ]
            ];
            return response()->json($data, $status_code);
        }else{
            $delete = $kit->delete();
            if($delete){
                $status_code    = 200;
                $data           = [
                    "status_code"   => $status_code,
                    "message"       => "Success",
                    "data"          => [
                        "kit"       => "Deleted"
                    ]
                ];
                return response()->json($data, $status_code);
            }
        }

    }
    public function link(Request $request){
        $validator = Validator::make($request->all(), [
            'code_kit'  => 'required',
        ]);
        $code_kit   = $request->code_kit;
        $kit        = Kit::where('code',$code_kit)->first();
        if($validator->fails()){
            $status_code    = 422;
            $data           = [
                "status_code"   => $status_code,
                "message"       => "gagal Validasi",
                "data"          => [
                    "errors"    => $validator->errors()
                ]
            ];
            return response()->json($data, $status_code);
        }else if(empty($kit)){
            $status_code    = 404;
            $data           = [
                "status_code"   => $status_code,
                "message"       => "Not Found",
                "data"          => [
                    "kits"    => $kit
                ]
            ];
            return response()->json($data, $status_code);
        }else{
            $data_kit       = [
                'kit_code'      => $kit->code,
                'nik_petugas'   => $kit->operator['nik'],
                'time'          => time(),
                'id_pasien'     => Auth()->id(),
                'petugas'       => [
                    'id'        => $kit->operator['id'],
                    'nik'       => $kit->operator['nik']
                ]

            ];
            $log_user_kit       = new Log_user_kit();
            $add_log_user_kit   = $log_user_kit->create($data_kit);
            $update_kit         = $kit->update([
                    'pasien'    => [
                        'id_pasien' => Auth()->id(),
                        'time'      => time()
                    ]
                ]

            );
            $status_code    = 200;
            $data           = [
                "status_code"   => $status_code,
                "message"       => "Success",
                "data"          => [
                    "kits"    => $kit
                ]
            ];
            return response()->json($data, $status_code);
        }
    }
    public function unlink(Request $request){
        $validator = Validator::make($request->all(), [
            'code_kit'  => 'required',
        ]);
        $code_kit   = $request->code_kit;
        $kit        = Kit::where('code',$code_kit)->where('pasien','!=',NULL)->first();
        if($validator->fails()){
            $status_code    = 422;
            $data           = [
                "status_code"   => $status_code,
                "message"       => "gagal Validasi",
                "data"          => [
                    "errors"    => $validator->errors()
                ]
            ];
            return response()->json($data, $status_code);
        }else if(empty($kit)){
            $status_code    = 404;
            $data           = [
                "status_code"   => $status_code,
                "message"       => "Not Found",
                "data"          => [
                    "kits"    => $kit
                ]
            ];
            return response()->json($data, $status_code);
        }else{
            $data_kit       = [
                'kit_code'      => $kit->code,
                'nik_petugas'   => $kit->operator['nik'],
                'time'          => time(),
                'id_pasien'     => Auth()->id()
            ];

            $update_kit         = $kit->update([
                    'pasien'    => NULL
                ]

            );
            $status_code    = 200;
            $data           = [
                "status_code"   => $status_code,
                "message"       => "Success",
                "data"          => [
                    "kits"    => $kit
                ]
            ];
            return response()->json($data, $status_code);
        }
    }
    private function customer($code){
        $customer = Customer::where('code', $code)->first();
        return response($customer);
    }
}
