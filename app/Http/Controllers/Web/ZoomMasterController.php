<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use App\Models\User;
use App\Models\ZoomMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ZoomMasterController extends Controller
{
    public function index()
    {
        $zoomMaster = ZoomMaster::all();
        $data = [
            "title"         => "Master Zoom",
            "class"         => "Marital Status",
            "sub_class"     => "Get All",
            "content"       => "layout.admin",
            "zoom_masters"  => $zoomMaster
        ];

        return view('user.zoom_master.index', $data);
    }
    public function create()
    {
        $zoomMaster = new ZoomMaster();
        $counselors = User::where('counselor', true)->get();
        $data = [
            "title"         => "Master Zoom",
            "class"         => "Marital Status",
            "sub_class"     => "Get All",
            "content"       => "layout.admin",
            "zoom_master"   => $zoomMaster,
            "counselors"    => $counselors
        ];

        return view('user.zoom_master.create', $data);
    }
    public function store(Request $request)
    {
        $zoom_master = new ZoomMaster();
        $data_post = $request->all();
        $data_post['creator']=Auth::id();
        $create = $zoom_master->create($data_post);
        if($create){
            session()->flash('success', 'Master Zoom Telah Dibuat');
            return redirect()->route('zoom.master.index');
        }
    }
    public function edit($id)
    {
        $zoomMaster = ZoomMaster::find($id);
        $counselors = User::where('counselor', true)->get();
//        dd( $zoomMaster);
        $data = [
            "title"         => "Master Zoom",
            "class"         => "Marital Status",
            "sub_class"     => "Get All",
            "content"       => "layout.admin",
            "zoom_master"   => $zoomMaster,
            "counselors"    => $counselors
        ];

        return view('user.zoom_master.edit', $data);
    }
    public function update(Request $request, $id)
    {
        $zoom_master = ZoomMaster::find($id);
        $data_post = $request->all();
        $data_post['creator']=Auth::id();
        $update = $zoom_master->update($data_post);
        if($update){
            session()->flash('success', 'Master Zoom Telah behasil diubah');
            return redirect()->route('zoom.master.index');
        }
    }
}
