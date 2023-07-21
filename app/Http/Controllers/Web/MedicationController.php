<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Drug;
use App\Models\Medication;
use App\Models\MedicationSchedule;
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
            'drug'          => 'required',
            'frequency'     => 'required',
            'unit_frequency'=> 'required',
            'dosage'        => 'required',
            'unit_dosage'   => 'required',
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
                        'dosage'        => (float) $request->dosage,
                        'unit_dosage'   => $request->unit_dosage
                    ],
                    'frequency' => [
                        'frequency'         => (float) $request->frequency,
                        'unit_frequency'    => $request->unit_frequency
                    ],
                    'qty'       => [
                        'qty'       => (int) $request->qty,
                        'unit_qty'  => $request->unit_qty,
                    ]
                ];
                $create = $medication->create($post_data);
                if($create){
                    session()->flash('success', 'Obat sukses disimpan');
                    return redirect()->back();
                }
            }

        }
    }
    public function show($id)
    {
        $medication = Medication::find($id);
        $jadwal     = MedicationSchedule::where([
            'medication.id' => $medication->id
        ])->orderBy('time', 'ASC');
        $data = [
            "title"         => "Medication Detail",
            "class"         => "medication",
            "sub_class"     => "detail",
            "content"       => "layout.user",
            "medication"    => $medication,
            "user"          => Auth::user(),
            "jadwal"        => $jadwal->get(),
            "count_jadwal"  => $jadwal->count()
        ];
        return view('user.medication.show', $data);
    }

}
