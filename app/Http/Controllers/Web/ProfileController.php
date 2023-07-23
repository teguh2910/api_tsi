<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Drug;
use App\Models\Medication;
use App\Models\Observation;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function profile()
    {
        $url        = "https://dev.atm-sehat.com/api/v1/over-view/latest";
        $client     = new Client();
        $session_token = decrypt(session('web_token'));
//        dd($session_token);
        $header = [
            'Authorization' => "Bearer $session_token",
        ];
        $response   = $client->get($url, [
            'headers'       => $header
        ]);
        $data = json_decode($response->getBody());
//        dd($data->data);
        $user           = Auth::user();
        $observation    = Observation::where('id_pasien', Auth::id())->orderBy('time', 'DESC');
        $family         = User::where('family.id_induk', Auth::id())->get();
        $data = [
            "title"         => "Profile",
            "class"         => "user",
            "sub_class"     => "profile",
            "content"       => "layout.user",
            "user"          => $user,
            "observation"   => $observation->get(),
            "family"        => $family,
            "resume"        => $data->data
        ];
        return view('user.profile.profile', $data);
    }
    public function user($id)
    {
        $user           = User::find($id);
        $observation    = Observation::where('id_pasien', $id)->orderBy('time', 'DESC');
        $medication     = Medication::where('pasien.id', $id)->orderBy('created_at', 'DESC');
        $drug           = Drug::all();
        $data = [
            "title"         => "Profile",
            "class"         => "user",
            "sub_class"     => "profile",
            "content"       => "layout.user",
            "user"          => $user,
            "observation"   => $observation->get(),
            "medication"    => $medication->get(),
            "drugs"         => $drug
        ];
        return view('user.profile.profile', $data);
    }
}
