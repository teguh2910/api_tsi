<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Education\StoreEducationRequest;
use App\Http\Requests\Education\UpdateEducationRequest;
use App\Http\Resources\EducationResource;
use App\Models\Education;

class EducationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $educations = EducationResource::collection(Education::OrderBy('grade', 'ASC')->get()) ;
        $data   = [
            "status"        => "success",
            "status_code"   => 200,
            "time"          => time(),
            "content"       => $educations
        ];
        return response()->json($data,200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $education = new Education();
//        dd($educations);
        $data       = [
            'title'         => 'Tambah Pendidikan',
            'class'         => 'Education',
            'sub_class'     => 'Create',
            'education'     => $education
        ];
        return view('admin.education.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Education\StoreEducationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEducationRequest $request)
    {
        $education = new Education();
        $data_input = $request->all();
        $create     = $education->create($data_input);
        if($create){
            return redirect()->route('education')->with('success', 'Data berhasil disimpan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Education  $education
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $education = Education::find($id);
        $data       = [
            'title'         => 'Tambah Pendidikan',
            'class'         => 'Education',
            'sub_class'     => 'Show',
            'education'     => $education
        ];
        return view('admin.education.show', $data);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Education  $education
     * @return \Illuminate\Http\Response
     */
    public function edit(Education $education)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Education\UpdateEducationRequest  $request
     * @param  \App\Models\Education  $education
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEducationRequest $request, $id)
    {
        $education  = Education::find($id);
        $data_input = $request->all();
//        dd(json_encode($data_input));
        $update     = $education->update($data_input);
        if($update){
            return redirect()->route('education')->with('success', 'Data berhasil diupdate');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Education  $education
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $destroy    = Education::destroy($id);
        if($destroy){
            return redirect()->route('education')->with('success', 'Data berhasil dihapus');
        }
    }
}
