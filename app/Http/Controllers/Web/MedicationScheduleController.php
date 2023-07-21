<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Medication;
use App\Models\MedicationSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MedicationScheduleController extends Controller
{
    public function store(Request $request, $id)
    {
        $medication = Medication::where('_id', $id)->first();
//        dd($medication);
        $validator = Validator::make($request->all(), [
            'time'          => 'required',
        ]);
        $jadwal     = new MedicationSchedule();
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }else{
            $data_input = [
                'medication'    => [
                    'id'        => $medication->id,
                    'pasien'    => $medication->pasien,
                    'drug'      => $medication->drug,
                    'frequency' => $medication->frequency,
                    'dosage'    => $medication->dosage
                ],
                'time'          => $request->time
            ];
            $create = $jadwal->create($data_input);
            if($create){
                session()->flash('success', 'Jadwal sukses disimpan');
                return redirect()->back();
            }
        }
    }
}
