<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ActivationRequest;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\UpdatePasswordRequest;
use App\Jobs\Auth\ActivationUserNotificationJob;
use App\Jobs\Auth\ForgetPasswordJob;
use App\Jobs\Auth\LoginNotificationJob;
use App\Jobs\Auth\RegistrationNotificationJob;
use App\Jobs\Auth\RequestActivationCodeJob;
use App\Jobs\Auth\UpdatePasswordNotificationJob;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Halaman yang memberikan informasi gagal authorisasi
     *
     * @return \Illuminate\Http\Response
     */
    public function notAuthorised(){
        $data = [
            'status_code'   => 401,
            'message'       => 'Not Authorized',
        ];
        return response()->json($data,401);

    }
    /**
     * halaman login, diperlukan username dan password
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('username', 'password')))
        {
            $data = [
                "status_code"   => 401,
                'message'       => 'Unauthorized',
                'time'          => time()
            ];
            return response()->json($data, 401);

        }else{
            $token_name = 'auth_token';
            $user       = User::where('username', $request['username'])->firstOrFail();
            if($user->active == true){
                $token      = $user->createToken($token_name)->plainTextToken;
                $data       = [
                    "status_code"   => 200,
                    'message'       => 'Success',
                    "token"         => [
                        "name"      => $token_name,
                        "code"      => $token,
                        "type"      => 'Bearer',
                        "user_id"   => $user->id
                    ],
                    'time'          => time()
                ];
                if(!empty($token)){
                    $data_email = [
                        'content'   => auth()->user(),
                        'server'    => [
                            'ip'        => $_SERVER['REMOTE_ADDR'],
                            'browser'   => $_SERVER['HTTP_USER_AGENT'],
                            'time'      => time()
                        ]
                    ];
                    $sending_mail = dispatch(new LoginNotificationJob($data_email));
                    return response()->json($data, 200);
                }
            }else{
                $data       = [
                    "status_code"   => 203,
                    'message'       => 'Account is Not Active',
                ];
                return response()->json($data, 203);
            }
            return response()
                ->json($data, 200);
        }
    }
    public function login_petugas(Request $request)
    {
        if (!Auth::attempt($request->only('username', 'password')))
        {
            $data = [
                "status_code"   => 401,
                'message'       => 'Unauthorized',
                'time'          => time()
            ];
            return response()->json($data, 401);

        }else{
            $token_name = 'auth_token';
            $user       = User::where('username', $request['username'])->firstOrFail();
            if($user->active == true){
                $token      = $user->createToken($token_name)->plainTextToken;
                $data       = [
                    "status_code"   => 200,
                    'message'       => 'Success',
                    "token"         => [
                        "name"      => $token_name,
                        "code"      => $token,
                        "type"      => 'Bearer',
                        "user_id"   => $user->id
                    ],
                    'time'          => time()
                ];
                if($user->level != "petugas"){
                    return response()->json([
                        'status_code'   => 401,
                        'message'       => 'Bukan Petugas'
                    ], 401);
                }
                if(!empty($token)){
                    $data_email = [
                        'content'   => auth()->user(),
                        'server'    => [
                            'ip'        => $_SERVER['REMOTE_ADDR'],
                            'browser'   => $_SERVER['HTTP_USER_AGENT'],
                            'time'      => time()
                        ]
                    ];
                    $sending_mail = dispatch(new LoginNotificationJob($data_email));
                    return response()->json($data, 200);
                }
            }else{
                $data       = [
                    "status_code"   => 203,
                    'message'       => 'Account is Not Active',
                ];
                return response()->json($data, 203);
            }
            return response()
                ->json($data, 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return [
            'message' => 'You have successfully logged out and the token was successfully deleted'
        ];
    }

    /**
     * Halaman untuk melihat user yang sedang login
     */

    public function user(){
        $data = [
            'status_code'   => 200,
            'message'       => 'success',
            'data'          => Auth::user()
        ];
        return response()->json($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_depan'        => 'required',
            'nama_belakang'     => 'required',
            'gender'            => 'required',
            'nik'               => 'required|integer|unique:users,nik',
            'email'             => 'required|email:rfc,dns|unique:users,kontak.email',
            'nomor_telepon'     => 'required|unique:users,kontak.nomor_telepon',
            'tempat_lahir'      => 'required',
            'tanggal_lahir'     => 'required|date'

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
        $input = [
            'nama'      => [
                'nama_depan'    => $request->nama_depan,
                'nama_belakang' => $request->nama_belakang
            ],
            'gender'            => $request->gender,
            'nik'               => (int) $request->nik,
            'lahir'     => [
                'tempat'    => $request->tempat_lahir,
                'tanggal'   => $request->tanggal_lahir
            ],
            'kontak'    => [
                'email'         => $request->email,
                'nomor_telepon' => $request->nomor_telepon
            ],
            'username'  => $request->email,
            'password'  => bcrypt($request->password),
            'aktifasi'  => [
                'otp'   => rand(100000,999999),
                'exp'   => time()+(24*60*60)
            ],
            'active'    => false,
            'level'     => 'user'
        ];

        $user               = new User();
        $add                = $user->create($input);
        $data_email = [
            'content'=> $input
        ];

        $sending_mail = dispatch(new RegistrationNotificationJob($data_email));
        $time_end   = microtime(true);

        if($add){
            $data           = [
                "status_code"   => 201,
                "message"       => "Success",
            ];
            return response()->json($data, 201);
        }
        return response()->json([
            'message' => 'faild'
        ]);
    }
    public function activation_request(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'     => 'required|email',
            'nomor_telepon'  => 'required|numeric'
        ]);
        if($validator->fails()){
            $status_code = 422;
            return response()->json([
                'status_code'   => $status_code,
                'message'       => 'Gagal validasi',
                'errorrs'       => $validator->errors()
            ], $status_code);
        }
        $user_data = User::where([
            'kontak.email'  => $request->email,
            'kontak.nomor_telepon'  => $request->nomor_telepon,

        ]);
        $user_count = $user_data->count();
        if($user_count <1){
            return response()->json([
                'status_code'   => 404,
                'message'       => 'Not Found'
            ], 404);
        }
        $user = $user_data->first();
        $now    = time();
        if($user->active == true){
            $status_code = 400;
            return response()->json([
                'status_code'   => $status_code,
                'message'       => 'Permohonan aktifasi ditolak, karena akun sudah aktif'
            ], $status_code);
        }elseif ($user['aktifasi']['exp'] > $now){
            $status_code = 400;
            return response()->json([
                'status_code'   => $status_code,
                'message'       => 'Anda memiliki OTP yang masih aktif'
            ], $status_code);

        }
        $user['aktifasi'] = [
            'otp'   => rand(100000,999999),
            'exp'   => time()+(24*60*60)
        ];
        $creating_code = $user->update();
        $data_email = [
            'content'=> $user
        ];
        if($creating_code){
            dispatch(new RequestActivationCodeJob($data_email));
            return response()->json([
                'status_code'   => 200,
                'message'       => 'Sukses, OTP berhasil dikirim ke email yang terdaftar'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function aktifasi_akun(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'     => 'required|email',
            'otp'  => 'required|numeric'
        ]);
        if($validator->fails()){
            return response()->json([
                'status_code'   => 203,
                'message'       => 'Gagal validasi',
                'errorrs'       => $validator->errors()
            ]);
        }

        $user   = User::where('aktifasi.otp', $request->otp)->where('kontak.email', $request->email)->first();
        if(!empty($user)){
            $time = time();
            if($user->aktifasi['exp'] < $time){
                return response()->json([
                    'status_code'   => '203',
                    'message'       => 'Kode aktifasi kadaluarsa'
                ], 203);
            }
            $user['active'] = true;
            $user['aktifasi']="";
            $update = $user->update();
            if($update){
                $data_email = [
                  'content' => $user
                ];
                $sending_mail = dispatch(new ActivationUserNotificationJob($data_email));
            }
            return response()->json([
                'status_code'   => '200',
                'message'       => 'Sukses'
            ], 200);
        }
        $data = [
            'status_code'   => 404,
            'message'       => "Data not Found"
        ];
        return response()->json($data, 404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function forgot_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'     => 'required|email',
            'nomor_telepon'  => 'required|numeric'
        ]);
        if($validator->fails()){
            return response()->json([
                'status_code'   => 203,
                'message'       => 'Gagal validasi',
                'errorrs'       => $validator->errors()
            ]);
        }
        $time   = time();

        $user_data   = User::where([
            'kontak.email'         => $request->email,
            'kontak.nomor_telepon' => $request->nomor_telepon
        ]);

        $user_count = $user_data->count();
        if($user_count < 1 ){
            return response()->json([
                'status_code'   => 404,
                'message'       => 'Data Not Found'
            ]);
        }

        $user   = $user_data->first();

        if(isset($user->forgot_password['exp'])){
            $exp_di_DB = $user->forgot_password['exp'];

            if($exp_di_DB > $time){
                return response()->json([
                    'status_code'       => 400,
                    'message'           => 'Anda mempuntai token yang masih aktif',
                    'data'              => [
                        'waktu_kadaluarsa'  => date('Y-m-d H:i:s', $user->forgot_password['exp'])
                    ]
                ],400);
            }
            if(empty($user)){
                $data = [
                    'status_code'   => 404,
                    'message'       => "Data Not Found"
                ];
                return response()->json($data, 404);
            }else{
                $user['forgot_password'] = [
                    'code'          => rand('100000', 999999),
                    'created_at'    => time(),
                    'exp'           => time()+(5*60)
                ];
                $data = [
                    'status_code'   => 200,
                    'message'       => 'Permohonan reset password telah dikirim ke alamat email terdaftar'
                ];
                $update     = $user->update();
                $data_email = [
                    "content"     => $user
                ];
                $sending_email = dispatch(new ForgetPasswordJob($data_email));
                return response()->json($data, 200);
            }

        }else{
            $user['forgot_password'] = [
                'code'          => rand('100000', 999999),
                'created_at'    => time(),
                'exp'           => time()+(5*60)
            ];
            $data = [
                'status_code'   => 200,
                'message'       => 'Permohonan reset password telah dikirim ke alamat email terdaftar'
            ];
            $update     = $user->update();
            $data_email = [
                "content"     => $user
            ];
            $sending_email = dispatch(new ForgetPasswordJob($data_email));
            return response()->json($data, 200);
        }


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_password(UpdatePasswordRequest $request)
    {
        $validator = Validator::make($request->all(),[
            'otp'       => 'required',
            'username'  => 'required',
            'password'  => 'required|confirmed'
        ]);
        if ($validator->fails()){
            $data = [
                "status_code"   => 422,
                "message"       => "Validation failed",
                "data"          => [
                    'errors'    => $validator->errors(),
                ],
                "time"          => time()
            ];
            return response()->json($data,422);
        }
        $user   = User::where([
            'forgot_password.code'  => $request->otp,
            'username'          => $request->username
        ])->first();
        $now    = time();
        if( empty($user)){
            $data = [
                'status_code'   => 404,
                'message'       => 'Not Found',
            ];
            return response()->json($data, 404);
        }elseif ($user->forgot_password['exp'] > $now){
            $user['password']           = bcrypt($request->password);
            $user['forgot_password']    = "";
            $update = $user->update();
            if($update){
                $data_email = [
                    "content"     => $user
                ];
                dispatch(new UpdatePasswordNotificationJob($data_email));
                $data = [
                    'status_code'   => 205,
                    'message'       => 'password updated',
                ];
                return response()->json($data, 205);
            }
        }else{
            $data = [
                'status_code'   => 404,
                'message'       => 'OTP expired',
                'time'          => $now,
                'data'          => [
                    'otp'       => $user->forgot_password
                ],

            ];
            return response()->json($data, 404);
        }
    }


    public function update_user(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "username"      => 'required',
            "nama_depan"    => 'required',
            "nama_belakang" => 'required',
            "email"         => 'required'
        ]);
        $data_input = [
            'nama'      => [
                'nama_depan'        => $request->nama_depan,
                'nama_belakang'     => $request->nama_belakang
            ],
            'gelar'     => [
                'gelar_depan'       => $request->gelar_depan,
                'gelar_belakang'    => $request->gelar_belakang
            ],
            ''

        ];

        $user = Auth::user();
        if ($validator->fails()) {
            $data = [
                "status_code" => 301,
                "message" => "Validation failed",
                "error" => $validator->errors(),
                "time" => time()
            ];
            return response()->json($data, 301);
        }else{
            $update = $user->update();
        }

    }
}
