<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PetugasController extends Controller
{
    public function index()
    {
        $user       = User::where('level', 'petugas');
        $petugas    = [
            'count'     => $user->count(),
            'user'      => $user->get()
        ];
        $data = [
            "title"         => "Petugas",
            "class"         => "user",
            "sub_class"     => "petugas",
            "content"       => "layout.user",
            "petugas"       => $petugas,
            "user"          => Auth::user()
        ];
        return view('admin.petugas.index', $data);
    }
    public function create()
    {
        $users = User::where([
            'level'     => 'user'
        ])->orderBy('nama.nama_depan', 'ASC')->get();
        $customers = Customer::all();
        $data = [
            "title"         => "Petugas",
            "class"         => "user",
            "sub_class"     => "petugas",
            "content"       => "layout.user",
            "users"         => $users,
            "user"          => Auth::user(),
            "organisations" => $customers,
        ];
        return view('admin.petugas.create', $data);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_user'           => 'required',
            'id_organisation'   => 'required',
            'role'              => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }else{
            $organisation = Customer::find($request->id_organisation);
//            dd($organisation);
            $user = User::find($request->id_user);
            $data_petugas = [
                'organisation'  => [
                  'id'      => $organisation->_id,
                  'name'    => $organisation->name,
                  'role'    => $request->role
              ],
                'level'         => 'petugas'
            ];
            $update = $user->update($data_petugas);
            if($update){
                session()->flash('success', "Sukses menambahkan petugas baru");
                return redirect()->back();
            }
        }
    }
}
