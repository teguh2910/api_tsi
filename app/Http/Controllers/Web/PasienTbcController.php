<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PasienTbcController extends Controller
{
    public function index()
    {
        $data = [
            "title"         => "Profile",
            "class"         => "user",
            "sub_class"     => "profile",
            "content"       => "layout.user",
            "medications"   => $medication->get(),
            "drugs"         => $drug,
            "user"          => Auth::user()
        ];
        return view('user.pasien_tbc.index', $data);
    }
    public function mine()
    {
        $pasien_tbc = User::where('tbc.counselor', Auth::id());
        $data = [
            "title"         => "Pasien",
            "class"         => "user",
            "sub_class"     => "tbc",
            "content"       => "layout.user",
            "pasien_tbc"    => $pasien_tbc->get(),
            "user"          => Auth::user()
        ];
        return view('user.patient_tbc.mine', $data);

    }
    public function create(Request $request,$id_counselor)
    {
        $counselor  = User::find($id_counselor);
        $nomor_telepon = $request->nomor_telepon;
        $pasien = User::where('kontak.nomor_telepon', $nomor_telepon);

        $data = [
            "title"         => "Search Patient",
            "class"         => "user",
            "sub_class"     => "patient",
            "content"       => "layout.user",
            "counselor"     => $counselor,
            "user"          => Auth::user(),
            "pasien"        => $pasien->first()

        ];
        return view('user.patient_tbc.search', $data);
    }
    public function store(Request $request, $id_counselor)
    {

        $validator = Validator::make($request->all(), [
            'id_pasien'      => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }else{
            $pasien = User::where('_id', $request->id_pasien);
            if($pasien->count() <1 ){
                return redirect()->back()
                    ->withInput();
            }else{
                $data_update = [
                    'tbc'   => [
                        'counselor' => $id_counselor,
                        'time'      => time()
                    ]
                ];
                $create_new_patien = $pasien->update($data_update);
                if($create_new_patien){
                    session()->flash('success', 'Sukses menambahkan pasien baru');
                    return back();
                }
            }
        }
    }
    public function destroy($id)
    {
        $pasien_tbc = User::where('_id', $id);
        if($pasien_tbc->count() < 1){
            session()->flash('danger', 'Pasien salah');
            return back();
        }else{
            $data_update = [
                'tbc'   => null
            ];
            $update = $pasien_tbc->update($data_update);
            session()->flash('success', 'Pasien berhasil dihapus');
            return back();
        }
    }

}
