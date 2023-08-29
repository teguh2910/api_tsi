<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Medication;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CounselorController extends Controller
{
    public function index()
    {
        $counselor = User::where('counselor', true);
        $users = User::OrderBy('nama.nama_depan', 'ASC')->get();
        $data = [
            "title"         => "Daftar Konselor TBC",
            "class"         => "user",
            "sub_class"     => "counselor",
            "content"       => "layout.user",
            "counselors"    => $counselor->get(),
            "user"          => Auth::user(),
            "users"         => $users

        ];
        return view('user.counselor.index', $data);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_user'      => 'required',
        ]);
        $counselor = User::where('_id', $request->id_user);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }else{
            $data_ubah = [
                'counselor' => true
            ];
            $create = $counselor->update($data_ubah);
            if($create){
                session()->flash('success', 'Sukses menambahkan konselor baru');
                return redirect()->back();
            }
        }

    }
    public function show($id)
    {
        $counselor = User::where('_id', $id)->first();
        $pasien = User::where('tbc.counselor', $id)->get();
        $users = User::OrderBy('nama.nama_depan', 'ASC')->get();
        $data = [
            "title"         => "Counselor",
            "class"         => "user",
            "sub_class"     => "counselor",
            "content"       => "layout.user",
            "counselor"     => $counselor,
            "user"          => Auth::user(),
            "users"         => $users,
            "pasien"        => $pasien
        ];
        return view('user.counselor.show', $data);
    }
    public function destroy($id)
    {
        $counselor = User::where('_id', $id)->first();
        $update = $counselor->update([
            'counselor'     => false
        ]);
        session()->flash('success', 'Sukses menhapus konselor');
        return redirect()->back();
    }


}
