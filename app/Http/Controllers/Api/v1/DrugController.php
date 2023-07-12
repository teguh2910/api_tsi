<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Drug;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DrugController extends Controller
{
    public function index()
    {
        $drug = Drug::all();
        if($drug->count() < 1){
            $status_code    = 404;
            $message        = "Not Found";
            $data           = [
                'drug'      => $drug,
                'count'     => $drug->count()
            ];
        }else{
            $status_code    = 200;
            $message        = "success";
            $data           = [
                'drug'      => $drug
            ];
        }
        $response = [
            'status_code'   => $status_code,
            'message'       => $message,
            'data'          => $data
        ];
        return response()->json($response,$status_code);
    }
    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'name'          => 'required|unique:drugs,name',
            'drug_category' => 'required'
        ]);
        if ($validator->fails()) {
            $status_code    = 422;
            $message        = "Gagal Validasi";
            $data = [
                'errors' => $validator->errors(),
            ];
        }else{
            $data_drug = [
                'name'      => $request->name,
                'category'  => $request->drug_category
            ];
            $drug       = new Drug();
            $create     = $drug->create($data_drug);
            if($create){
                $status_code    = 200;
                $message        = "success";
                $data           = [
                    'drug'      => $data_drug
                ];
            }else{
                $status_code    = 204;
                $message        = "Un success";
                $data           = [
                    'drug'      => $data_drug
                ];
            }
        }
        $response = [
            'status_code'   => $status_code,
            'message'       => $message,
            'data'          => $data
        ];
        return response()->json($response,$status_code);
    }
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'drug_id'       => 'required',
            'name'          => 'required|unique:drugs,name',
            'drug_category' => 'required'
        ]);
        if ($validator->fails()) {
            $status_code    = 422;
            $message        = "Gagal Validasi";
            $data = [
                'errors' => $validator->errors(),
            ];
        }
    }
}
