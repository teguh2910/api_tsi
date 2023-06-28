<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\user\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\City;
use App\Models\Province;
use App\Models\User;
use GPBMetadata\Google\Api\Auth;
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
            "data"          => [
                'count'     => User::count(),
                'users'     => $user
            ]
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
        $data_user = [
            'id'            => $user->id,
            'nama_depan'    => $user->nama['nama_depan'],
            'nama_belakang' => $user->nama['nama_belakang'],
            'gelar_depan'   => $user->gelar['gelar_depan'],
            'gelar_belakang'=> $user->gelar['gelar_belakang'],
            'gende'         => $user->gender,
            'tanggal_lahir' => $user->lahir['tanggal'],
            'tempat_lahir'  => $user->lahir['tempat'],
            'nik'           => $user->nik,
            'email'         => $user->kontak['email'],
            'nomor_telepon' => $user->kontak['nomor_telepon'],
        ];
        $data = [
            "status"        => "success",
            "status_code"   => 200,
            "time"          => time(),
            "data"          => $data_user
        ];
        return response()->json($data,200);

    }
    public function find(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nik' => 'required|numeric'
        ]);
        $nik    = $request->nik;
        $user   = User::where('nik', (int)$nik)->first();

        if ($validator->fails()) {
            $data = [
                "status_code"   => 422,
                "message"       => "Gagal validasi",
                "data"          => [
                    "errors" => $validator->errors(),
                ],
            ];
            return response()->json($data, 422);
        }elseif (empty($user)){
            $data = [
                "status_code"   => 404,
                "message"       => "Not Found",

            ];
            return response()->json($data, 404);
        }
        $user_publish = [
            'id'            => $user->id,
            'nama_depan'    => $user->nama['nama_depan'],
            'nama_belakang' => $user->nama['nama_belakang'],
            'tanggal_lahir' => $user->lahir['tanggal'],
            'tempat_lahir'  => $user->lahir['tempat'],
            'email'         => $user->kontak['email'],
            'nomor_telepon' => $user->kontak['nomor_telepon'],
        ];
        $data = [
            "status_code"   => 200,
            "message"       => "Success",
            "data"          => [
                "user"      => $user_publish
            ]

        ];
        return response()->json($data, 200);

    }
    public function findByemail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);
        $email    = $request->email;
        $user   = User::where('kontak.email', $email)->first();

        if ($validator->fails()) {
            $data = [
                "status_code"   => 422,
                "message"       => "Gagal validasi",
                "data"          => [
                    "errors" => $validator->errors(),
                ],
            ];
            return response()->json($data, 422);
        }elseif (empty($user)){
            $status_code = 404;

        }
        $status_code = 200;
        $data = [
            "status_code"   => $status_code,
            "message"       => "success",
            "data"          => [
                'id'        => $user->_id,
                'nik'       => $user->nik,
                "nama"      => $user->nama,
                'gender'    => $user->gender,
                'gelar'     => $user->gelar,
                'lahir'     => $user->lahir,
                'kontak'    => $user->kontak,
                'active'    => $user->active
            ]

        ];
        return response()->json($data, $status_code);

    }
    public function showNik($nik)
    {
        $user_query = User::where('nik', (int)$nik);
        $user = $user_query->first();
        if(empty($user))
        {
            return response()->json([
                'status_code'   => 404,
                'message'       => 'Not Found'
            ], 404);
        }
        $data_user = [
            'id'            => $user->id,
            'nama_depan'    => $user->nama['nama_depan'],
            'nama_belakang' => $user->nama['nama_belakang'],
            'tanggal_lahir' => $user->lahir['tanggal'],
            'tempat_lahir'  => $user->lahir['tempat'],
            'email'         => $user->kontak['email'],
            'nomor_telepon' => $user->kontak['nomor_telepon'],
        ];

        return response()->json($data_user, 200);


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $data_validasi = [
            'nama_depan'            => 'required',
            'nama_belakang'         => 'required',
            'gelar_depan'           => 'required',
            'gelar_belakang'        => 'required',
            'gender'                => 'required',
            'nik'                   => 'required|numeric|digits:16',
            'nomor_telepon'         => 'required|numeric|digits_between:10,13',
            'email'                 => 'required|email:rfc,dns',
            'tanggal_lahir'         => 'required',
            'tempat_lahir'          => 'required|date',
            'status_menikah'        => 'required',
        ];
        $data_input     = [
            'nama'              => [
                'nama_depan'    => $request->nama_depan,
                'nama_belakang' => $request->nama_belakang
            ],
            'gelar'             => [
                'gelar_depan'    => $request->gelar_depan,
                'gelar_belakang' => $request->gelar_belakang
            ],
            'gender'            => $request->gender,
            'nik'               => $request->nik,
            'kontak'            => [
                'email'         => $request->email,
                'nomor_telepon' => $request->nomor_telepon
            ],
            'status_menikah'    => $request->status_menikah
        ];

        $validator = Validator::make($request->all(),$data_validasi);
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
        $update = $user->update($data_input);
        $data = [
            'message'   => 'Success',
            'code'      => 200,
            'update'    => $update,
            'data'      => User::find($user->id)
        ];
        return response()->json($data);
    }
    public function update_address(UpdateUserRequest $request, User $user)
    {
        $provinsi   = Province::where('id_provinsi', $request->id_provinsi)->first();
        $kota       = City::where('city_id', $request->city_id)->first();
        $user['address']= [
            'provinsi'  => [
                'id_provinsi'   => $provinsi->id_provinsi,
                'nama_provinsi' => $provinsi->nama_provinsi
            ],
            'kota'  => [
                'id_kota'       => $provinsi->id_kota,
                'nama_kota'     => $provinsi->nama_kota
            ],
            'kecamatan'  => [
                'id_kecamatan'      => $provinsi->id_kecamatan,
                'nama_kecamatan'    => $provinsi->nama_kecamatan
            ],
            'kelurahan'  => [
                'id_kelurahan'      => $provinsi->id_provinsi,
                'nama_kelurahan'    => $provinsi->nama_kelurahan
            ],
            'kode_pos'  => ''

        ];
        $update = $user->update();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);
        $id    = $request->id;
        $user   = User::find($id);

        if ($validator->fails()) {
            $data = [
                "status_code"   => 422,
                "message"       => "Gagal validasi",
                "data"          => [
                    "errors" => $validator->errors(),
                ],
            ];
            return response()->json($data, 422);
        }
        $user = User::find((string)$id);
        if(empty($user)){
            $data = [
                'status_code'    => 404,
                'message'        => 'Not Found',
                'data'          => [
                    'user'      => $user
                ]
            ];
            return response()->json($data, 404);
        }
        $delete=$user->delete();
        //jika sukses menghapus data
        if($delete){
            $data = [
                'status_code'    => 200,
                'message'        => 'sccess',
                'data'           => [
                    'user'      =>  $user
                ]
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

    public function restore(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);
        $id    = $request->id;
        $user   = User::where('_id', $id);

        if ($validator->fails()) {
            $data = [
                "status_code"   => 422,
                "message"       => "Gagal validasi",
                "data"          => [
                    "errors" => $validator->errors(),
                ],
            ];
            return response()->json($data, 422);
        }
        $data_user  = $user->first();
        $user_count = $user->count();
        if($user_count <1 ){
            $data = [
                'status_code'   => 404,
                'message'       => 'Not Found',
                'data'          => [
                    'user'      => $data_user
                ]
            ];
            return response()->json($data);
        }

        $restore    = $user->withTrashed()->restore();

        if($restore){
            $data = [
                'status_code'   => 200,
                'message'       => 'sccess',
                'data'          => [
                    'user'      =>  $data_user
                ]
            ];
            return response()->json($data);
        }
        if($restore){
            $data = [
                'status_code'   => 404,
                'message'       => 'Not Found',
                'data'          => [
                    'user'      =>  $data_user
                ]
            ];
            return response()->json($data, 404);
        }
    }
}
