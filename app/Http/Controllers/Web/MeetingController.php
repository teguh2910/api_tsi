<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use App\Models\User;
use App\Models\ZoomMaster;
use GuzzleHttp\Client;
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
            $user_host  = User::find($host);
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
                $receiver   = $user_host->kontak['nomor_telepon'];
                $message    = "Hallo ".$user_host->nama['nama_depan']."\r\n".
                                "Terdapat $topic pada ".$date_time ."\r\n".
                                "Silahkan validasi pertemuan ini pada E-TBC apps";
                //sending whatsapp
                $sending_wa = $this->sending_whatsapp($receiver, $message);
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
            $date_start     = $request->date_start;
            $time_start     = $request->time_start;
            $host           = Auth::id();
            $attendee       = $request->attendee;
            $pasien         = User::find($attendee);
            $nama_attendee  = $pasien->nama['nama_depan'];
            $topic          = "Tele Konsultasi E-TBC $nama_attendee";
            $time           = strtotime($request->date_start." ".$request->time_start);
            $date_time      = date('Y-m-d H:i:s', $time);
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
                session()->flash('success', "E Konsultasi TBC $nama_attendee telah diajukan");
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
        $user       = Auth::user();
        $meeting    = Meeting::find($id);
        $data = [
            "title"     => "Meeting",
            "class"     => "Meeting",
            "sub_class" => "Show",
            "content"   => "layout.admin",
            "meeting"   => $meeting,
            "user"      => $user
        ];

        return view('user.meeting.show', $data);
    }
    public function validation($id)
    {
        $zoom_master = ZoomMaster::all();
        $meeting = Meeting::find($id);
        $data = [
            "title"     => "Meeting",
            "class"     => "Meeting",
            "sub_class" => "Show",
            "content"   => "layout.admin",
            "meeting"   => $meeting,
            "zoom_master"=> $zoom_master
        ];
        return view('user.meeting.validation', $data);
    }
    public function update(Request $request, $id)
    {
        $meeting = Meeting::find($id);
        $zoom_master = ZoomMaster::find($request->zoom_master);
        $data_update = [
            'id_meeting'    => $zoom_master->id_meeting,
            'pass_code'     => $zoom_master->pass_code,
            'url'           => $zoom_master->url,
            'zoom'          => [
                'id'        => $zoom_master->id,
                'room_name' => $zoom_master->room_name
            ]
        ];
        $update = $meeting->update($data_update);
        if($update){
            return redirect()->route('meeting.show',['id'=>$id]);
        }
    }
    public function meeting($id){

    }
    private function sending_whatsapp($receiver, $message)
    {
        $url_sending_wa = "https://wa.atm-sehat.com/send";
        $header         = [];
        $client         = new Client();
        $sending        = $client->post($url_sending_wa, [
            'headers'       => $header,
            'form_params'   => [
                'number'    => '6281213798746',
                'message'   => $message,
                'to'        => '62'.(int) $receiver,
                'type'      => 'chat'
            ]
        ]);
    }
}
