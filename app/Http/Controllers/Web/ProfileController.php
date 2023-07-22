<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Drug;
use App\Models\Medication;
use App\Models\Observation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function profile()
    {
//        dd(session()->all());
//        dd(decrypt(session('web_token')));
        $user           = Auth::user();
        $observation    = Observation::where('id_pasien', Auth::id())->orderBy('time', 'DESC');
        $medication     = Medication::where('id_pasien', Auth::id())->orderBy('time', 'DESC');
        $drug           = Drug::all();
        $data = [
            "title"         => "Profile",
            "class"         => "user",
            "sub_class"     => "profile",
            "content"       => "layout.user",
            "user"          => $user,
            "observation"   => $observation->get(),
            "medication"    => $medication,
            "drugs"         => $drug
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
