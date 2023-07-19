<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MeetingController extends Controller
{
    public function index()
    {
        $id_user        = Auth::id();
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
    public function store_by_pasien(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date_start'    => 'required|date',
            'time_start'    => 'required',
            'host'          => 'required'
        ]);

        $nama = Auth::user()['nama']['nama_depan'];
        if ($validator->fails()) {
            return redirect()->route('meeting.index')
                ->withErrors($validator)
                ->withInput();
        }else{
            $topic      = "Tele Konsultasi E-TBC $nama";
            $date_start = $request->date_start;
            $time_start = $request->time_start;
            $host       = $request->host;
            $time       = strtotime($request->date_start." ".$request->time_start);
            $date_time  = date('Y-m-d H:i:s', $time);
            $data_meeting = [
                "topic"         => $topic,
                "date_start"    => $date_start,
                "time_start"    => $time_start,
                "time"          => $time,
                "date_time"     => $date_time,
                "host"          => $host,
                "attendee"      => Auth::id()
            ];
            $meeting    = new Meeting();
            $create     = $meeting->create($data_meeting);
            if($create){
                session()->flash('success', 'E Konsultasi TBC telah diajukan');
                return redirect()->route('message.index');
            }
        }
    }
    public function store_by_counselor(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date_start'    => 'required|date',
            'time_start'    => 'required',
            'attendee'      => 'required'
        ]);

        $nama = Auth::user()['nama']['nama_depan'];
        if ($validator->fails()) {
            return redirect()->route('meeting.index')
                ->withErrors($validator)
                ->withInput();
        }else{
            $topic      = "Tele Konsultasi E-TBC $nama";
            $date_start = $request->date_start;
            $time_start = $request->time_start;
            $host       = Auth::id();
            $attendee   = $request->attendee;
            $time       = strtotime($request->date_start." ".$request->time_start);
            $date_time  = date('Y-m-d H:i:s', $time);
            $data_meeting = [
                "topic"         => $topic,
                "date_start"    => $date_start,
                "time_start"    => $time_start,
                "time"          => $time,
                "date_time"     => $date_time,
                "host"          => $host,
                "attendee"      => $attendee
            ];
            $meeting    = new Meeting();
            $create     = $meeting->create($data_meeting);
            if($create){
                session()->flash('success', 'E Konsultasi TBC telah diajukan');
                return redirect()->route('message.index');
            }
        }
    }
    public function mine()
    {
        $time   = time()-(15*60);
        $meetings = Meeting::where([
            'host'  => Auth::id()
        ]);
        $data = [
            "title"     => "Master Zoom",
            "class"     => "Marital Status",
            "sub_class" => "Get All",
            "content"   => "layout.admin",
            "meetings"  => $meetings->get()
        ];

        return view('user.meeting.host', $data);
    }
    public function show($id)
    {
        $meeting = Meeting::find($id);
        $data = [
            "title"     => "Meeting",
            "class"     => "Meeting",
            "sub_class" => "Show",
            "content"   => "layout.admin",
            "meeting"   => $meeting
        ];

        return view('user.meeting.show', $data);
    }
}
