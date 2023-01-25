<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Education\StoreEducationRequest;
use App\Http\Requests\Education\UpdateEducationRequest;
use App\Models\Education;
use App\Models\User;

class EducationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $educations = Education::OrderBy('grade', 'ASC')->get();
//        dd($educations);
        $data       = [
            'title'         => 'List Pendidikan',
            'class'         => 'Education',
            'sub_class'     => 'Get All',
            'educations'    => $educations
        ];
        return view('admin.education.index', $data);
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
