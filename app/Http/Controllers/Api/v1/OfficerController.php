<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class OfficerController extends Controller
{
    public function index()
    {
        $user = User::where('level', 'petugas');
        if($user->count()<1){
            $satatus_code   = 404;
            $message        = 'Petugas Kosong';
            $data           = [
                'count'     => $user->count(),
                'user'      => UserResource::collection($user->get())
            ];
        }else{
            $satatus_code   = 200;
            $message        = 'success';
            $data           = [
                'count'     => $user->count(),
                'user'      => UserResource::collection($user->get())
            ];
        }
        return response()->json([
            'status_code'    => $satatus_code,
            'message'        => $message,
            'data'           => $data
        ], $satatus_code);
    }
    public function store(Request $request)
    {
        $email      = $request->email;
        $role       = $request->role;
        $user       = User::where('kontak.email', $email);
        $validator  = Validator::make($request->all(), [
            'email' => 'required',
            'role'  => ['required',Rule::in(['user', 'petugas'])],
        ]);
        if($validator->fails()){
            $satatus_code   = 422;
            $message        = 'gagal validasi';
            $data           = [
                'errors' => $validator->errors()
            ];
        }else if($user->count() < 1 ){
            $satatus_code   = 404;
            $message        = 'Petugas Kosong';
            $data           = [
                'count'     => $user->count(),
                'user'      => $user->first()
            ];
        }else{
            $update = $user->update([
                'level' => $role
            ]);
            if($update){
                $satatus_code   = 200;
                $message        = 'User update successfully';
                $data           = [
                    'count'     => $user->count(),
                    'user'      => $user->first()
                ];
            }else{
                $satatus_code   = 204;
                $message        = 'User update Not successfully';
                $data           = [
                    'count'     => $user->count(),
                    'user'      => $user->first()
                ];
            }
        }
        return response()->json([
            'status_code'    => $satatus_code,
            'message'        => $message,
            'data'           => $data
        ], $satatus_code);
    }

}
