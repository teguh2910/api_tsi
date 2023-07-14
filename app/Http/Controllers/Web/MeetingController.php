<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    public function index()
    {
        $id_user        = "64ab60837fb2f5709001bbe2";
        $meetings       = Meeting::where('id_pasien', $id_user)->orderBy('time', 'DESC');
        $data = [
            "title"         => "Profile",
            "class"         => "user",
            "sub_class"     => "profile",
            "content"       => "layout.admin",
            "meetings"      => $meetings->get()
        ];
        return view('user.meeting.index', $data);
    }
}
