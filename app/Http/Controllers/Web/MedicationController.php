<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Drug;
use App\Models\Medication;
use App\Models\Observation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MedicationController extends Controller
{
    public function mine()
    {
        $medication     = Medication::where('pasien.id', Auth::id())->orderBy('created_at', 'DESC');
        $drug           = Drug::all();
        $data = [
            "title"         => "Profile",
            "class"         => "user",
            "sub_class"     => "profile",
            "content"       => "layout.user",
            "medications"   => $medication->get(),
            "drugs"         => $drug,
            "user"          => Auth::user()
        ];
        return view('user.medication.mine', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'drug'      => 'required',
            'dosage'    => 'required',
            'unit'      => 'required',
            'qty'       => 'required'
        ]);
        $medication = new Medication();
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }else{
            $db_medication = Medication::where([
                'pasien.id' => Auth::id(),
                'drug.id'   => $request->drug,
            ]);
            if($db_medication->count() > 0 ){
                session()->flash('danger', 'Obat pernah dimasukkan');
                return redirect()->back();
            }else{
                $drug = Drug::find($request->drug);
                $pasien = Auth::user();
                $data_pasien    = [
                    'id'            => Auth::id(),
                    'name'          => $pasien->nama,
                    'gender'        => $pasien->gender,
                    'nik'           => $pasien->nik,
                    'tanggal_lahir' => $pasien->lahir['tanggal']
                ];
                $data_obat  = [
                    'id'        => $drug->id,
                    'name'      => $drug->name
                ];
                $post_data = [
                    'pasien'    => $data_pasien,
                    'drug'      => $data_obat,
                    'dosage'    => [
                        'frekwensi' => (int) $request->dosage,
                        'unit'      => $request->unit
                    ],
                    'qty'       => (int) $request->qty
                ];
                $create = $medication->create($post_data);
                if($create){
                    session()->flash('success', 'Obat sukses disimpan');
                    return redirect()->back();
                }
            }

        }
    }

}
