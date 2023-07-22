<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Personal_access_token;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('auth.login');
    }
    public function login()
    {
        $user = Auth::user();
        return view('auth.login');
    }
    public function postLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username'        => 'required|email',
            'password'        => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->route('auth.login')
                ->withErrors($validator)
                ->withInput();
        }
        $post = [
            'username'  => $request->username,
            'password'  => $request->password
        ];
        $post_json = json_encode($post);
        $credentials = $post;
        if (Auth::attempt($credentials)) {

            $url        = "https://dev.atm-sehat.com/api/v1/auth/login";
            $header = [];
            $client     = new Client();
            $response   = $client->post($url, [
                'headers' => $header,
                'form_params' => [
                    'username'  => $request->username,
                    'password'  => $request->password,
                ]
            ]);
            $data = json_decode($response->getBody(), true);
            $data_token     = $data['token']['code'];
            $encryptedData  = encrypt($data_token);
            session(['web_token' => $encryptedData]);
            $request->session()->regenerate();
            return redirect()->route('profile.index');
        }else{
            session()->flash('gagal_login', 'Wrong username or password');

            return redirect()->route('auth.login');
        }

    }
    public function register()
    {
        return view('auth.register');
    }
    public function daftar(Request $request)
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
        if ($validator->fails()) {
            return redirect()->route('auth.register')
                ->withErrors($validator)
                ->withInput();
        }else{
            $post=$request->all();
            $url        = "https://dev.atm-sehat.com/api/v1/auth/register";
            $client = new Client();
            $response = $client->post($url, [
                'form_params' => $post
            ]);
            $statusCode = $response->getStatusCode();
            if($statusCode==201){
                session()->flash('success', 'Success Registration');
                return redirect()->route('auth.activate');
            }
        }
    }
    public function forgotPassword()
    {
        return view('auth.forgotPassword');
    }
    public function getPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nomor_telepon' => 'required|numeric',
            'email'         => 'required|email',
        ]);
        $user = User::where([
            'kontak.nomor_telepon'  => $request->nomor_telepon,
            'kontak.email'          => $request->email
        ]);
        $data_user = $user->first();
        $post_data  = [
            'nomor_telepon' => $request->nomor_telepon,
            'email'         => $request->email
        ];
        if ($validator->fails()) {
            return redirect()->route('auth.forgotPassword')
                ->withErrors($validator)
                ->withInput();
        }elseif($user->count() < 1) {
            session()->flash('danger', 'User tidak ditemukan');
            return redirect()->route('auth.forgotPassword')
                ->withInput();
        }elseif ($data_user->forgot_password != null){
            $otp        = $data_user->forgot_password['code'];
            $exp_otp    = $data_user->forgot_password['exp'];
            if($exp_otp > time()){
                $sisa_waktu = (round(($exp_otp-time())/60,0))." menit";
                session()->flash('danger', "Anda masih memiliki OTP aktif, silahkan periksa email anda, sisa waktu $sisa_waktu");
                return redirect()->route('auth.forgotPassword')
                    ->withInput();
            }else{
                $url        = "https://dev.atm-sehat.com/api/v1/auth/forgotpassword";
                $client     = new Client();
                $response   = $client->post($url, [
                    'form_params' => $post_data
                ]);
                $statusCode = $response->getStatusCode();
                if($statusCode == 200){
                    session()->flash('success', 'Permohonan reset akun telah diterima, periksa email anda');
                    return redirect()->route('auth.forgotPassword');
                }
            }
        }else{
            $url        = "https://dev.atm-sehat.com/api/v1/auth/forgotpassword";
            $client     = new Client();
            $response   = $client->post($url, [
                'form_params' => $post_data
            ]);
            $statusCode = $response->getStatusCode();
            if($statusCode == 200){
                session()->flash('success', 'Permohonan reset akun telah diterima, periksa email anda');
                return redirect()->route('auth.forgotPassword');
            }
        }

    }

    public function reset_password()
    {
        return view('auth.reset_password');
    }
    public function do_reset_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp'       => 'required|numeric|digits:6',
            'username'  => 'required|email',
            'password'  => 'required|confirmed',

        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }else{
            $user = User::where([
                'forgot_password.code'  => (int) $request->otp,
                'username'              => $request->username
            ]);
            $data_user = $user->first();
//            dd($data_user);
            if($user->count() < 1){
                session()->flash('danger', 'User tidak ditemukan');
                return redirect()->back()->withInput();
            }elseif($data_user->forgot_password['exp'] < time()){
                session()->flash('danger', 'OTP Kadaluarsa');
                return redirect()->back()->withInput();
            }else{
                $post_data  = $request->all();
                $url        = "https://dev.atm-sehat.com/api/v1/auth/resetpassword";
                $client     = new Client();
                $response   = $client->put($url, [
                    'form_params' => $post_data
                ]);
                $statusCode = $response->getStatusCode();
                if($statusCode == 200){
                    session()->flash('success', 'Password berhasil direset');
                    return redirect()->route('auth.login');
                }
            }
        }
    }
    public function activate()
    {
        return view('auth.activate');
    }
    public function do_activate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp'    => 'required|numeric|digits:6',
            'email'  => 'required|email',

        ]);
        if ($validator->fails()) {
            return redirect()->route('auth.activate')
                ->withErrors($validator)
                ->withInput();
        }else{
            $post_data  = $request->all();
            $url        = "https://dev.atm-sehat.com/api/v1/auth/aktifasi";
            $client     = new Client();
            $response   = $client->put($url, [
                'form_params' => $post_data
            ]);
            $statusCode = $response->getStatusCode();
            if($statusCode == 200){
                session()->flash('success', 'Akun berhasil diaktifkan');
                return redirect()->route('auth.login');
            }else{
                session()->flash('danger', 'Akun gagal diaktifkan');
                return redirect()->route('auth.login');
            }
        }
    }
    public function logout(Request $request)
    {
        $session_token  = decrypt(session('web_token'));
        $words          = explode("|", $session_token);
        $id_token       =  $words['0'];
        $delete_token   = Personal_access_token::where('_id', $id_token)->delete();
        if($delete_token){
            $request->session()->flush();
            Auth::logout();
            return redirect()->route('auth.login');
        }else{
            return redirect()->route('auth.login');
        }
    }


}
