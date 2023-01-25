<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ethnic\StoreEthnicRequest;
use App\Http\Requests\Ethnic\UpdateEthnicRequest;
use App\Models\Ethnic;
use Illuminate\Http\Request;

class EthnicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ethnic = Ethnic::all();
        $data = [
            "title"         => "Daftar Ethnik di Indonesia",
            "class"         => "Ethnic",
            "sub_class"     => "Get All",
            "content"       => "layout.admin",
            "ethnic"        => $ethnic,
        ];
        return view('admin.ethnic.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ethnic = new Ethnic();
        $data = [
            "title"         => "Daftar Ethnik di Indonesia",
            "class"         => "Ethnic",
            "sub_class"     => "Get All",
            "content"       => "layout.admin",
            "ethnic"        => $ethnic,
        ];
        return view('admin.ethnic.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEthnicRequest $request)
    {
        $input = $request->validated();
        $ethnic= new Ethnic();
        $create = $ethnic->create($input);
        if($create){
            $data =[
                'status'    => 'success',
                'status_code'   => 200,
                'content'   => $input
            ];
            return redirect()->route('ethnic')->with('success', 'Data berhasil disimpan');
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
        $ethnic = Ethnic::find($id);
        $data   = [
            "title"         => "Daftar Ethnik di Indonesia",
            "class"         => "Ethnic",
            "sub_class"     => "Get All",
            "content"       => "layout.admin",
            "ethnic"        => $ethnic,
        ];
        return view('admin.ethnic.show', $data);
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
    public function update(UpdateEthnicRequest $request, $id)
    {
        $input = $request->validated();
        $ethnic = Ethnic::find($id);
        $update = $ethnic->update($input);
        if($update){
            return redirect()->route('ethnic')->with('success', 'Data berhasil disimpan');
        }else{
            return redirect()->route('ethnic')->with('danger', 'Data gagal disimpan');
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
        $destroy = Ethnic::destroy($id);
        if($destroy){
            return redirect()->route('ethnic')->with('success', 'Data berhasil dihapus');
        }
    }
    public function restore($id)
    {
        $restore = Ethnic::withTrashed()
            ->where('_id', $id)
            ->restore();

        if($restore){
            return redirect()->route('ethnic')->with('success', 'Data berhasil dipulihkan');
        }

    }
}
