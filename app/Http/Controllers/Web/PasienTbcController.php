<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PasienTbcController extends Controller
{
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
    public function search(Request $request, $id_counselor)
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
                    return redirect()->route('counselor.show', ['id'=>$id_counselor]);
                }
            }
        }



    }
    public function store(Request $request, $id_counselor)
    {
        $validator = Validator::make($request->all(), [
            'id_pasien'      => 'required',
        ]);
        $pasien = User::where('_id', $request->id_pasien);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
    }
}
