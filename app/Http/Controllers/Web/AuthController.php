<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }
    public function postLogin(Request $request)
    {
        $post = [
            'username'  => $request->username,
            'password'  => $request->password
        ];
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
            return redirect()->route('profile.index');
        }else{
            return $json_decode;
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

}
