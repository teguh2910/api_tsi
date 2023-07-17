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
        $credentials = $post;
        if (Auth::attempt($credentials)) {
            $url        = "https://dev.atm-sehat.com/api/v1/auth/login";
            $client = new Client();
            $response = $client->post($url, [
                'form_params' => $post
            ]);
            $statusCode = $response->getStatusCode();
            $body = $response->getBody()->getContents();
            $json_decode = json_decode($body);
            if($statusCode == 200){
                $encryptedData = encrypt($body);
                session(['body' => $encryptedData]);
//            return redirect()->route('profile.index');
            }else{
                return $json_decode;
            }
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
    public function forgotPassword()
    {
        return view('auth.forgotPassword');
    }
    public function logout(Request $request)
    {
        $session        = json_decode(decrypt(session('body')));
//        dd($session);
        $session_token  = $session->token->code;
//        dd($session_token);
        $words          = explode("|", $session_token);
        $id_token       =  $words['0'];
        $delete_token   = PersonalAccessToken::where('_id', $id_token)->delete();
        if($delete_token){
            $request->session()->flush();
            Auth::logout();
            return redirect()->route('auth.login');
        }else{
            dd($session);
        }

    }
    public function token()
    {
        $token = "641654c99b95649322006944|Q2GWBEoZ8gnbeS3eS6XX1seAMdGHCaXpAgSgekcl";
        $words = explode("|", $token);
        echo $words['0'];

//        foreach ($words as $word) {
//            echo $word . "<br>";
//        }
    }

}
