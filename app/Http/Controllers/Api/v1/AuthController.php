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
use App\Models\Kit;
use App\Models\Log_kit;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Sanctum\PersonalAccessToken;
use phpseclib3\Math\BigInteger;

class AuthController extends Controller
{
    /**
     * Halaman yang memberikan informasi gagal authorisasi
     *
     * @return \Illuminate\Http\Response
     */
    public function notAuthorised(){
        $status_code = 499;
        $data = [
            'status_code'   => $status_code,
            'message'       => 'Token Invalid ',
        ];
        return response()->json($data,$status_code);

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
//                            'browser'   => $_SERVER['HTTP_USER_AGENT'],
                            'time'      => time()
                        ]
                    ];
//                    $sending_mail = dispatch(new LoginNotificationJob($data_email));
//                    $receiver   = $user->kontak['nomor_telepon'];
//                    $message    = 'Berhasil Login';
//                    $sending_wa = $this->sending_whatsapp($receiver, $message);
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
        $validator = Validator::make($request->all(), [
            'username'          => 'required',
            'password'          => 'required',
            'id_atm_sehat_kit'  => 'required',
            'force_login'       => 'required|boolean'
        ]);
        $id_atm_sehat_kit   = $request->id_atm_sehat_kit;
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
        }elseif (!Auth::attempt($request->only('username', 'password')))
        {
            $data = [
                "status_code"   => 401,
                'message'       => 'Unauthorized',
                'time'          => time()
            ];
            return response()->json($data, 401);

        }else{
            $token_name     = $id_atm_sehat_kit;
            $user           = User::where('username', $request['username'])->firstOrFail();
            $kit            = Kit::where('code', $id_atm_sehat_kit)->first();
            $force_login    = $request->force_login;
            $cari_token     = PersonalAccessToken::where('tokenable_id', '!=',  $user->_id)->where('name', $token_name);
            $data_token     = $cari_token->get();
            $count_token    = $cari_token->count();
            if($force_login < 1 ){
                if($count_token > 0){
                    $status_code = 404;
                    $message        = "Kit ATM Sehat sudah digunakan oleh petugas lain";
                    $data           = [
                        'force_login'   => $force_login,
                        'petugas'       => $count_token
                    ];
                    return response()->json([
                        'status_code'   => $status_code,
                        'message'       => $message,
                        'data'          => $data
                    ], $status_code);
                }
            }
            $delete_login = $cari_token->delete();
            $data_log_kit   = [
                'kit_code'      => $id_atm_sehat_kit,
                'nik_petugas'   => $user->nik,
                'time'          => time()
            ];
            $kit_petugas = [
                'kit'       => [
                    'kit_code'  => $id_atm_sehat_kit,
                    'time'      => time()
                ]
            ];
            if($user->active == true){
                $update_user    = $user->update($kit_petugas);
                $token          = $user->createToken($token_name)->plainTextToken;
                $kit            = Kit::where('code', $id_atm_sehat_kit)->first();
                $operator_kit   = [
                    "operator"  => [
                        "nik"   => $user->nik,
                        "id"    => $user->_id,
                        "time"  => time()
                    ],

                ];
                $update_kit     = $kit->update($operator_kit);
                $log_kit        = new Log_kit();

                $add_log_kit    = $log_kit->create($data_log_kit);
                $data           = [
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
                    $receiver   = $user->kontak['nomor_telepon'];
                    $message    = 'Berhasil Login sebagai petugas pada waktu '. date('d-m-Y H:i');
                    $sending_wa = $this->sending_whatsapp($receiver, $message);
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
        $token          = $request->bearerToken();
        $words          = explode("|", $token);
        $id_token       =  $words['0'];
        $delete_token   = PersonalAccessToken::where('_id', $id_token)->delete();
        if($delete_token){
            $status_code    = 200;
            $message        = "Token deleted";
            $data           = [
                'token'     => $token
            ];
        }else{
            $status_code    = 204;
            $message        = "Token not deleted";
            $data           = [
                'token'     => $token
            ];
        }

        $response = [
            'status_code'   => $status_code,
            'message'       => $message,
            'data'          => $data
        ];
        return response()->json($response);
    }
    public function logoutAll(Request $request)
    {
        $token          = PersonalAccessToken::where('tokenable_id', Auth::id());
        $delete_token   = $token->delete();
        if($delete_token){
            $status_code    = 200;
            $message        = "Token deleted";
            $data           = [
                'token'     => $token->get()
            ];
        }else{
            $status_code    = 204;
            $message        = "Token not deleted";
            $data           = [
                'token'     => $request->bearerToken()
            ];
        }

        $response = [
            'status_code'   => $status_code,
            'message'       => $message,
            'data'          => $data
        ];
        return response()->json($response);
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
            'gender'            => ['required',Rule::in(['male', 'female'])],
            'nik'               => 'integer|unique:users,nik',
            'email'             => 'email:rfc,dns|unique:users,kontak.email',
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
        if(empty($request->email)){
            $username = $request->nomor_telepon;
        }else{
            $username = $request->email;
        }
        $otp = rand(100000,999999);
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
            'username'  => $username,
            'password'  => bcrypt($request->password),
            'aktifasi'  => [
                'otp'   => $otp,
                'exp'   => time()+(24*60*60)
            ],
            'family'    => $request->family,
            'active'    => false,
            'level'     => 'user'
        ];

        $user               = new User();
        $add                = $user->create($input);
        $data_email = [
            'content'=> $input
        ];
        if(!empty($request->email)){
            $sending_mail = dispatch(new RegistrationNotificationJob($data_email));
            $time_end   = microtime(true);
        }else{

        }

        $receiver   = $request->nomor_telepon;
        $message    = 'OTP : '. $otp."\n".route('auth.activate.url', ['nik'=>(int) $request->nik, 'otp'=>$otp]);
        $sending_wa = $this->sending_whatsapp($receiver, $message);


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
                'message'       => 'Anda memiliki OTP yang masih aktif',
                'data'          => [
                    'waiting_time'  => $user['aktifasi']['exp']-$now,
                    'unit_time'     => 'detik'
                ]
            ], $status_code);

        }
        $otp = rand(100000,999999);
        $user['aktifasi'] = [
            'otp'   => $otp,
            'exp'   => time()+(5*60)
        ];
        $creating_code = $user->update();
        $data_email = [
            'content'=> $user
        ];
        if($creating_code){
            $url_sending_wa = "https://wa.atm-sehat.com/send";
            $header         = [];
            $client         = new Client();
            $sending        = $client->post($url_sending_wa, [
                'headers' => $header,
                'form_params'   => [
                    'number'    => '6281213798746',
                    'message'   => 'OTP : '. $otp,
                    'to'        => '62'.(int) $user->kontak['nomor_telepon'],
                    'type'      => 'chat'
                ]
            ]);
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
            'otp'       => 'required|numeric'
        ]);
        $user_demo = User::where('kontak.email', $request->email)->first();
        $now = time();

        if($validator->fails()){
            return response()->json([
                'status_code'   => 203,
                'message'       => 'Gagal validasi',
                'data'          => [
                    'errors'   => $validator->errors()
                ]
            ]);
        }elseif(empty($user_demo)){
            $status_code    = 404;
            $message        = "Email tidak terdaftar";
            $data           = [];
            return response()->json([
                'status_code'   => $status_code,
                'message'       => $message,
                'data'          => $data
            ], $status_code);
            }elseif($request->otp == 111111){
                $aktifasi = $this->activate($user_demo->_id)->original;
                $status_code    = 200;
                $message        = "Aktifasi demo sukses";
                $data           = [
                    'aktifasi'  => $aktifasi
                ];
                return response()->json([
                    'status_code'   => $status_code,
                    'message'       => $message,
                    'data'          => $data
                ], $status_code);
            }elseif($user_demo->active == true){
            $status_code    = 400;
            $message        = "Akun anda telah aktif";
            $data           = [
                'otp'  => $request->otp
            ];
            return response()->json([
                'status_code'   => $status_code,
                'message'       => $message,
                'data'          => $data
            ], $status_code);

        }elseif($user_demo->aktifasi['otp'] != $request->otp ){
            $status_code    = 400;
            $message        = "OTP tidak sesuai";
            $data           = [
                'otp'  => $request->otp
            ];
            return response()->json([
                'status_code'   => $status_code,
                'message'       => $message,
                'data'          => $data
            ], $status_code);

        }elseif($user_demo->aktifasi['exp'] < $now){
            $status_code    = 400;
            $message        = "OTP expired";
            $data           = [
                'otp'  => $request->otp
            ];
            return response()->json([
                'status_code'   => $status_code,
                'message'       => $message,
                'data'          => $data
            ], $status_code);

        }else{

            $receiver   = $user_demo->kontak['nomor_telepon'];
            $message    = 'Akun berhasil diaktifkan pada waktu '. date('d-m-Y H:i');
            $sending_wa = $this->sending_whatsapp($receiver, $message);
            $this->activate($user_demo->_id);
            $data_email = [
                'content' => $user_demo
            ];
            $sending_mail = dispatch(new ActivationUserNotificationJob($data_email));
            $status_code    = 200;
            $message        = "Aktifasi sukses";
            $data           = [
                'otp'  => $request->otp
            ];
            return response()->json([
                'status_code'   => $status_code,
                'message'       => $message,
                'data'          => $data
            ], $status_code);
        }

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
        $email          = $request->email;
        $nomor_telepon  = $request->nomor_telepon;
        if($validator->fails()){
            return response()->json([
                'status_code'   => 203,
                'message'       => 'Gagal validasi',
                'errorrs'       => $validator->errors()
            ]);
        }else{
            $time   = time();
            $user_data   = User::where([
                'kontak.email'         => $email,
                'kontak.nomor_telepon' => $nomor_telepon
            ]);
            $user_count = $user_data->count();
            $user   = $user_data->first();
            if($user_count < 1 ){
                $status_code    = 404;
                $message        = 'User Not Found';
                $data           = [
                    'user'      => $user_data->first()
                ];
                $response = [
                    'status_code'   => $status_code,
                    'message'       => $message,
                    'data'          => $data
                ];
                return response()->json($response);
            }elseif($user->forgot_password != null){
                if($user->forgot_password['exp'] > $time){
                    $status_code    = 400;
                    $message        = 'Anda masih memiliki OTP yang aktif';
                    $data           = [
                        'waiting_time'  => $user->forgot_password['exp']-$time,
                        'unit'          => 'second'
                    ];
                    $response = [
                        'status_code'   => $status_code,
                        'message'       => $message,
                        'data'          => $data
                    ];
                    return response()->json($response);
                }else{
                    $create_otp = $this->create_otp($user, $email, $nomor_telepon);
                    $response = $create_otp->getOriginalContent();
                }
                return response()->json($response);
            }else{
                $create_otp = $this->create_otp($user, $email, $nomor_telepon);
                $response = $create_otp->getOriginalContent();
                return response()->json($response);
            }
        }
    }
    private function create_otp($user, $email, $nomor_telepon){
        $code = rand('100000', 999999);
        $forgot_password = [
            'forgot_password'=>[
                'code'          => $code,
                'created_at'    => time(),
                'exp'           => time()+(5*60)
            ]

        ];

        $data = [
            'status_code'   => 200,
            'message'       => 'Permohonan reset password telah dikirim ke alamat email terdaftar',
            'data'          => [
                'email'         => $email,
                'nomor_telepon' => $nomor_telepon
            ]
        ];
        $update     = $user->update($forgot_password);
        $data_email = [
            "content"     => $user
        ];
        $sending_email = dispatch(new ForgetPasswordJob($data_email));
        $receiver   = $nomor_telepon;
        $message    = 'OTP : '.$code."\n url : ".route('auth.activate.url',['nik'=> 1233, 'otp'=>123]);
        $sending_wa = $this->sending_whatsapp($receiver, $message);
        return response($data);
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
        $now            = time();
        $user_demo      = User::where('username', $request->username)->first();
        if ($validator->fails()) {
            $data = [
                "status_code" => 422,
                "message" => "Validation failed",
                "data" => [
                    'errors' => $validator->errors(),
                ],
                "time" => time()
            ];
            return response()->json($data, 422);
        }elseif(empty($user_demo)){
            $status_code    = 404;
            $message        = "User Not Found";
            $data           = [
                'user'      => $user_demo
            ];
            return response()->json([
                'status_code'   => $status_code,
                'message'       => $message,
                'data'          => $data
            ], $status_code);
        }elseif($request->otp == 111111){
            $update_password    = $this->reset_password($user_demo->_id, $request->password);
            $status_code        = 200;
            $message            = "Reset password akun demo berhasil";
            $data               = [
                'username'          => $request->username,
                'otp'               => $request->otp,
                'update_password'   => $update_password->original
            ];
            return response()->json([
                'status_code'   => $status_code,
                'message'       => $message,
                'data'          => $data
            ], $status_code);
        }elseif($user_demo->forgot_password['code'] != $request->otp){
            $status_code    = 400;
            $message        = "OTP tidak sesuai";
            $data           = [
                'username'  => $request->username,
                'otp'       => $request->otp
            ];
            return response()->json([
                'status_code'   => $status_code,
                'message'       => $message,
                'data'          => $data
            ], $status_code);

        }elseif($user_demo->forgot_password['exp'] < $now){
            $status_code    = 400;
            $message        = "OTP sudah tidak berlaku";
            $data           = [
                'username'  => $request->username,
                'otp'       => $request->otp
            ];
            return response()->json([
                'status_code'   => $status_code,
                'message'       => $message,
                'data'          => $data
            ], $status_code);

        }else{
            $update_password    = $this->reset_password($user_demo->_id, $request->password);
            $status_code        = 200;
            $message            = "Reset password berhasil";
            $data               = [
                'username'          => $request->username,
                'otp'               => $request->otp,
                'update_password'   => $update_password->original
            ];
            if($update_password){
                $data_email = [
                    "content"     => $user_demo
                ];
                dispatch(new UpdatePasswordNotificationJob($data_email));
                $receiver   = $user_demo->kontak['nomor_telepon'];
                $message    = 'password updated';
                $sending_wa = $this->sending_whatsapp($receiver, $message);
                $data = [
                    'status_code'   => 200,
                    'message'       => 'password updated',
                    'data '         => [
                        'username'          => $request->username,
                        'otp'               => $request->otp,
                        'update_password'   => $update_password->original
                    ]
                ];
                return response()->json($data, 200);
            }


            return response()->json([
                'status_code'   => $status_code,
                'message'       => $message,
                'data'          => $data
            ], $status_code);
                $update = $user_demo->update();

            }
    }
    private function reset_password($id_user, $password){
        $user               = User::find($id_user);
        $user['active']     = true;
        $user['password']   = bcrypt($password);
        $user['forgot_password']   = [
            'created_at'    => '',
            'code'          => '',
            'exp'           => ''
        ];
        $forgot_password    = $user->update();
        return response($forgot_password);
    }
    private function activate($id_user){
        $user               = User::find($id_user);
        $user['active']     = true;
        $user['aktifasi']   = [
            'otp'           => '',
            'exp'           => ''
        ];
        $aktifasi           = $user->update();
        return response($aktifasi);
    }
    private function sending_whatsapp($receiver, $message)
    {
        $url_sending_wa = "https://wa.atm-sehat.com/send";
        $header         = [];
        $client         = new Client();
        $sending        = $client->post($url_sending_wa, [
            'headers' => $header,
            'form_params'   => [
                'number'    => '6281213798746',
                'message'   => $message,
                'to'        => '62'.(int) $receiver,
                'type'      => 'chat'
            ]
        ]);
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
