<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PasienTbcController extends Controller
{
    public function create($id_counselor)
    {
        $counselor  = User::find($id_counselor);
    }
    public function search(Request $request, $id_counselor)
    {

        $nomor_telepone = $request->nomor_telepone;
        $validator = Validator::make($request->all(), [
            'id_pasien'      => 'required',
        ]);
        $pasien = User::where('_id', $request->id_pasien);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }else{
            $pasien = User::where('kontak.nomor_telepone', $nomor_telepone);
            if($pasien->count() <1 ){
                return redirect()->back()
                    ->withInput();
            }else{
                $data_update = [
                    'tbc'   => [
                        'counselor' => $id_counselor,
                        'time'      => time(),
                        'diagnosis' => $diagnosis
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
