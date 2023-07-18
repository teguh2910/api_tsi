<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Drug;
use App\Models\Medication;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MedicationController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_pasien' => 'required',
            'drug'      => 'required',
        ]);
        $medication = new Medication();
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }else{
            $drug = Drug::find($request->drug);
            $pasien = User::find($request->id_pasien);
            $data_pasien    = [
                'id'            => $pasien->id,
                'name'          => $pasien->nama,
                'gender'        => $pasien->gender,
                'nik'           => $pasien->nik,
                'tanggal_lahir' => $pasien->lahir['tanggal']
            ];
            $data_obat  = [
                'id'    => $drug->id,
                'name'  => $drug->name
            ];
            $post_data = [
                'pasien'    => $data_pasien,
                'drug'      => $data_obat
            ];
            $create = $medication->create($post_data);
            if($create){
                return redirect()->back();
            }
        }
    }
}
