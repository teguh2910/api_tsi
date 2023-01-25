<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Religion\StoreReligionRequest;
use App\Http\Requests\Religion\UpdateReligionRequest;
use App\Models\Religion;
use Illuminate\Http\Request;

class ReligionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $religions = Religion::all();
        $data = [
            "title"         => "Religion List",
            "class"         => "Religion",
            "sub_class"     => "Get All",
            "content"       => "layout.admin",
            "religion"      => $religions,
        ];
        return view('admin.religion.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $religions = new Religion();
        $data = [
            "title"         => "Religion List",
            "class"         => "Religion",
            "sub_class"     => "Create New Religion",
            "content"       => "layout.admin",
            "religion"      => $religions,
        ];
        return view('admin.religion.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReligionRequest $request)
    {
        $input      = $request->validated();
        $religion   = new Religion();
        $create     = $religion->create($input);
        if($create){
            return redirect()->route('religion')->with('success', 'Data berhasil disimpan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $religion = Religion::find($id);
        $data = [
            "title"         => "Religion List",
            "class"         => "Religion",
            "sub_class"     => "Create New Religion",
            "content"       => "layout.admin",
            "religion"      => $religion,
        ];
        return view('admin.religion.edit', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReligionRequest $request, $id)
    {
        $religion = Religion::find($id);
        $input      = $request->validated();
        $update     = $religion->update($input);
        if($update){
            return redirect()->route('religion')->with('success', 'Data berhasil diupdate');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
