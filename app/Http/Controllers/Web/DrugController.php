<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Drug;
use App\Models\DrugCategory;
use App\Models\Medication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DrugController extends Controller
{
    public function index()
    {
        $drug = Drug::all();
        $drug_category = DrugCategory::all();
        $data = [
            "title"         => "Drugs",
            "class"         => "user",
            "sub_class"     => "profile",
            "content"       => "layout.user",
            "drugs"         => $drug,
            "drug_category" => $drug_category
        ];
//        dd($data);
        return view('admin.drug.index', $data);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'          => 'required',
            'doseForm'      => 'required',
            'totalVolume'   => 'required',
            'unit'          => 'required',
        ]);
        $drug = new Drug();
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }else{
            $data_post = [
                'name'          => $request->name,
                'doseForm'      => $request->doseForm,
                'totalVolume'   => [
                    'volume'    => (int) $request->totalVolume,
                    'unit'      => $request->unit
                ],
                'category'      => $request->category,
            ];
            $drug = Drug::where('name', $request->name);
            if($drug->count() > 0){
                session()->flash('danger', 'Obat sudah ada di database');
                return redirect()->back();
            }
            $create = $drug->create($data_post);
            if($create){
                session()->flash('success', 'Obat berhasil ditambahkan');
                return redirect()->back();
            }
        }

    }
    public function destroy($id)
    {
        $destroy = Drug::where('_id', $id)->delete();
        if($destroy){
            session()->flash('success', 'Sukses menghapus data obat');
            return back();
        }
    }
}
