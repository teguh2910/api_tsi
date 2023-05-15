<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Code;
use App\Models\Customer;
use App\Models\Kit;
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
    private function customer($code){
        $customer = Customer::where('code', $code)->first();
        return response($customer);
    }
}
