<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }
    public function register()
    {
        return view('auth.register');
    }
    public function forgotPassword()
    {
        return view('auth.forgotPassword');
    }
    public function postLogin(Request $request)
    {
        $browser= $_SERVER['HTTP_USER_AGENT'];
        $url    = "https://dev.atm-sehat.com/api/v1/auth/login";
        $body   = [
            'username'  => $request->username,
            'password'  => $request->password
        ];
        $method = "POST";
        $login = json_decode($this->curl($url, $body, $method, $browser)->getOriginalContent()) ;
        if($login->status_code != 200){
            return redirect()->to('/login')->with('data', $login);
        };
    }
    private function curl($url,$body='', $method='GET', $browser)
    {
        $_SERVER['HTTP_USER_AGENT'] = $browser;
        $post_data = json_encode($body);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => $post_data,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return response($response);

    }
}
