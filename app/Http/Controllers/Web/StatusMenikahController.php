<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Marital_status\StoreMaritalStatusRequest;
use App\Http\Requests\Marital_status\UpdateMaritalStatusRequest;
use App\Models\Marital_status;
use Illuminate\Http\Request;

class StatusMenikahController extends Controller

{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $marital_status = Marital_status::orderBy('status', 'ASC')->get();
        $data = [
            "title"             => "Marital Status",
            "class"             => "Marital Status",
            "sub_class"         => "Get All",
            "content"           => "layout.admin",
            "marital_status"    => $marital_status,
        ];
        return view('admin.marital_status.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $marital_status = new Marital_status();
        $data = [
            "title"             => "Marital Status",
            "class"             => "Marital Status",
            "sub_class"         => "Get All",
            "content"           => "layout.admin",
            "marital_status"    => $marital_status,
        ];
        return view('admin.marital_status.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMaritalStatusRequest $request)
    {
        $data           = $request->validated();
        $marital_status = new Marital_status();
        $create         = $marital_status->create($data);
        if($create){
            return redirect()->route('marital_status')->with('success', "Data berhasil disimpan");
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
        $marital_status = Marital_status::find($id);
        $data = [
            "title"             => "Marital Status",
            "class"             => "Marital Status",
            "sub_class"         => "Get All",
            "content"           => "layout.admin",
            "marital_status"    => $marital_status,
        ];
        return view('admin.marital_status.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $marital_status = Marital_status::find($id);
        $data = [
            "title"             => "Marital Status",
            "class"             => "Marital Status",
            "sub_class"         => "Get All",
            "content"           => "layout.admin",
            "marital_status"    => $marital_status,
        ];
        return view('admin.marital_status.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMaritalStatusRequest $request, $id)
    {
        $data           = $request->validated();
        $marital_status = Marital_status::find($id);
        $update         = $marital_status->update($data);
        if($update){
            return redirect()->route('marital_status')->with('success', "Data berhasil disimpan");
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
        $marital_status = Marital_status::find($id);
//        dd($marital_status);

        if( empty($marital_status) ){
            return redirect()->route('marital_status')->with('danger', "Data gagal dihapus");
        }else{
            $destroy        = $marital_status->destroy($id);
            if($destroy){
                return redirect()->route('marital_status')->with('success', "Data berhasil dihapus");
            }

        }


    }
}
