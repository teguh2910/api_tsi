<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user   = UserResource::collection(User::all());
        $data   = [
            "status"        => "success",
            "status_code"   => 200,
            "time"          => time(),
            "content"       => $user
        ];
        return response()->json($data,200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator              = Validator::make($request->all(), [
            'nama_depan'        => 'required',
            'nama_belakang'     => 'required',
            'email'             => 'required|unique:users,email|email',
            'nomor_telepone'    => 'required|unique:users,nomor_telepon|numeric',
        ]);
        if( !empty($request->foto)){
            $path       = '';
            $file_name  = '';
            $file_ext   = '';
            $new_file_name = time().random_int(1000,9000).".".$file_ext;
        }else{
            $new_file_name='';
        }
        $data_input = [
            'nama_depan'        => $request->nama_depan,
            'nama_belakang'     => $request->nama_belakang,
            'gender'            => $request->gender,
            'birth_date'        => $request->birth_date,
            'place_birth'       => $request->place_birth,
            'nik'               => $request->nik,
            'email'             => $request->email,
            'nomor_telepone'    => $request->nomor_telepone,
            'foto'              => $new_file_name,
            'password'          => Hash::make($request->password),
            'address'           => $request->address,
            'health_overview'   => $request->health_overview,
            'wallet'            => $request->wallet
            ];

        if ($validator->fails()){
            $data = [
                "error"     => $validator->errors(),
                "created"   => time(),
                "data"      => $data_input
            ];
            return response()->json($data,203);
        }
        $users = new User();
        $add = $users->create($data_input);
        if($add){
            $data = [
                'status'        => 'success',
                'status_code'   => 200,
                'time'          => time(),
                'contain'       => $request->all()
            ];
            return response()->json($data,200);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $data = [
            "status"        => "success",
            "status_code"   => 200,
            "time"          => time(),
            "data"          => $user
        ];
        return response()->json($data,200);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $data_input = [
            'email'             => 'required|email',
            'nama_depan'        => 'required',
            'nama_belakang'     => 'required',
            'nomor_telepone'    => 'required'
        ];
        $validator = Validator::make($request->all(),$data_input);
        if ($validator->fails()){
            return response()->json([
                "error"     => $validator->errors(),
                "created"   => time(),
                "data"      => $request->all()
            ],203);
        }
        if( !$user){
            return response()->json([
                'message'   => 'Not Found',
                'code'      => 404
            ],404);
        }
        $update = $user->update($request->all());
        $data = [
            'message'   => 'Success',
            'code'      => 200,
            'update'    => $update,
            'data'      => User::find($user->id)
        ];
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {

        $delete=$user->delete();
        //jika sukses menghapus data
        if($delete){
            $data = [
                'status'         => 'sccess',
                'status_code'    => 200,
                'data'           => $user
            ];
            return response()->json($data);
        }
        //jika gagal
        $data = [
            'status'         => 'failed',
            'status_code'    => 400,
            'data'           => $user
        ];
        return response()->json($data);
    }
}
