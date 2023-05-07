<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ConsultationController extends Controller
{
    public function index()
    {
        $consultation_query = Consultation::where('id_pasien', Auth::id());
        $count          = $consultation_query->count();
        $consultation = $consultation_query->get();
        if($count<1){
            return response()->json([
                'status_code'   => 404,
                'message'       => 'Not Found'
            ], 404);
        }

        return response()->json([
            'status_code'   => 200,
            'message'       => 'success',
            'data'          => [
                'consultation'  => $consultation
            ]
        ]);
    }
    public function store(Request $request)
    {
        $consultation = new Consultation();
        $validator = Validator::make($request->all(),[
            'id_konsultan'      => 'required',
        ]);
        if($validator->fails()){
            $starus_code = 422;
            return response()->json([
               'status_code'    => $starus_code,
               'message'        => 'Gagal validasi',
               'data'           => [
                   'errors'     => $validator->errors()
               ]
            ], $starus_code);
        }
        $input = [
            'id_konsultan'  => $request->id_konsultan,
            'id_pasien'     => Auth::id(),
            'tarif'         => (int)50000,
            'status'        => 'pending'

        ];
        $find_consultation = Consultation::where([
            'id_pasien'     => Auth::id(),
            'id_konsultan'  => $request->id_konsultan
        ])->orderBy('created_at', 'DESC')->first();
        if(empty($find_consultation)){
            $add = $consultation->create($input);
            return response()->json([
                'status_code'   => 201,
                'message'       => 'Success',
                'data'          => [
                    'consultation'  => $input
                ],
            ]);
        }elseif($find_consultation->status == 'open'){
            return response()->json([
                'status_code'   => '204',
                'message'       => 'anda masih memiliki konsultasi yg terbuka'
            ], 206);

        }elseif ($find_consultation->status == 'pending'){
            return response()->json([
                'status_code'   => '204',
                'message'       => 'anda memiliki konsultasi yg belum terbayar'
            ], 206);
        }else{
            $add = $consultation->create($input);
            return response()->json([
                'status_code'   => 201,
                'message'       => 'Success',
                'content'       => $input,
            ]);
        }
    }
    public function update(Request $request, $id)
    {
        $consultation   = Consultation::find($id);
        $validator      = Validator::make($request->all(), [
            'id_konsultan'  => 'required',
            'status'  => 'required'
        ]);
        if(empty($consultation)){
            return response()->json([
                'status_code'   => 404,
                'message'       => 'Consultation Not Found'
            ],404);
        }
        if($validator->fails()){
            return response()->json([
                'status_code'   => 304,
                'message'       => 'Gagal Validasi',
                'content'       => $validator->errors()
            ]);
        }else{
            $update = $consultation->update();
            if($update){

                return response()->json([
                    'status_code'   => 203,
                    'message'       => 'success'
                ]);
            }
        }
    }

}

