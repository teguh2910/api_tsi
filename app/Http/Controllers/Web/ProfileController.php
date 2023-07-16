<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Observation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function profile()
    {
        $user           = Auth::user();
        $observation    = Observation::where('id_pasien', Auth::id())->orderBy('time', 'DESC');
        $data = [
            "title"         => "Profile",
            "class"         => "user",
            "sub_class"     => "profile",
            "content"       => "layout.user",
            "user"          => $user,
            "observation"   => $observation->get()
        ];
        return view('user.profile.profile', $data);
    }
}
