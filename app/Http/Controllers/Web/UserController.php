<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\user\StoreUserRequest;
use App\Http\Requests\user\UpdateUserRequest;
use App\Models\Marital_status;
use App\Models\Province;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('nama.nama_depan', 'ASC')->get();
        $data = [
            "title"     => "Daftar User",
            "class"     => "User",
            "sub_class" => "Get All",
            "content"   => "layout.admin",
            "users"     => $users,
        ];
        return view('admin.user.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $token          = 'Authorization: Bearer 645706809498aea6a30091c2|QJESpLWRUr1CRQTwjvYQ4L3ZiuCvirpyLQccCh3d';
        $url            = 'https://dev.atm-sehat.com/api/v1/maritalStatus';
        $method         = 'GET';
        $pernikahan     = json_decode($this->curl_get($token, $url, $method)->original);
        $marital_status = $pernikahan->data->marital_status;
        $url            = 'https://dev.atm-sehat.com/api/v1/religion';
        $agama          = json_decode($this->curl_get($token, $url, $method)->original)->data->religion;
        $url            = 'https://dev.atm-sehat.com/api/v1/wilayah/provinsi';
        $provinces      = json_decode($this->curl_get($token, $url, $method)->original)->data->provinsi;
        $users          = new User();
        $data = [
            "title"         => "Detail User",
            "class"         => "User",
            "sub_class"     => "Get All",
            "content"       => "layout.admin",
            "marital_status"=> $marital_status,
            "agama"         => $agama,
            "users"         => $users,
            "provinsi"      => $provinces
        ];
        return view('admin.user.create', $data);

    }
    public function curl_get($token, $url, $method){
        $curl   = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST =>  $method,
            CURLOPT_HTTPHEADER => array($token),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return response($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $data_input = $request->all();
        $data_json = json_encode($data_input);
        dd($data_json);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        $data = [
            "title"     => "Detail User",
            "class"     => "User",
            "sub_class" => "Get All",
            "content"   => "layout.admin",
            "users"     => $user,
        ];
        return view('admin.user.show', $data);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
//        $user_json = json_encode($user);
//        return $user_json;

        $provinces= Province::orderBy('nama')->get();
        $data = [
            "title"     => "Edit User",
            "class"     => "User",
            "sub_class" => "Get All",
            "content"   => "layout.admin",
            "users"     => $user,
            "provinsi"  => $provinces,
        ];
        return view('admin.user.edit', $data);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $users              = User::find($id);
        $validasi           = $request->validated();
        if($validasi){
            $data           = $request->all();
            if($request->gelar_depan !=''){
                if($request->gelar_belakang !=''){
                    $data['nama']   = $request->gelar_depan.". ".$request->nama_depan." ".$request->nama_belakang.", $request->gelar_belakang";
                }else{
                    $data['nama']   = $request->gelar_depan.". ".$request->nama_depan." ".$request->nama_belakang;
                }
            }else if($request->gelar_belakang !=''){
                $data['nama']   = $request->nama_depan." ".$request->nama_belakang.", $request->gelar_belakang";
            }else{
            $data['nama']   = $request->nama_depan." ".$request->nama_belakang;
            }


            $update     = $users->update($data);
            if($update){
                return redirect()->route('users.index');
            }

        }


    }
    public function blokir(Request $request, $id)
    {
        $users      = User::find($id);
        $setuju     = $request->setuju;
        $update     = $users->update(['blokir' => 'Y']);
        if($update){
            return redirect()->route('users.index');

        }

    }

    public function kode($properti, $value)
    {
        $users = User::where($properti,'like', "%$value%")->orderBy('nama_depan')->get();
        $data = [
            "title"     => "Daftar User",
            "class"     => "User",
            "sub_class" => "Get All",
            "content"   => "layout.admin",
            "users"     => $users,
        ];
        return view('admin.user.index', $data);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $users = User::find($id);
        $destroy = $users->destroy($id);
        if($destroy){
            return redirect()->route('users.index');
        }
    }
}
