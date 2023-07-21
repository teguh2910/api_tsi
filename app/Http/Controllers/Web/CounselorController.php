<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Medication;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CounselorController extends Controller
{
    public function index()
    {
        $counselor = User::where('counselor', true);
        $users = User::OrderBy('nama.nama_depan', 'ASC')->get();
        $data = [
            "title"         => "Daftar Konselor TBC",
            "class"         => "user",
            "sub_class"     => "counselor",
            "content"       => "layout.user",
            "counselors"    => $counselor->get(),
            "user"          => Auth::user(),
            "users"         => $users

        ];
        return view('user.counselor.index', $data);
    }
    public function store(Request $request)
    {
        try {
            $session        = json_decode(decrypt(session('body')));
            $session_token  = $session->token->code;
            $url = "https://dev.atm-sehat.com/api/v1/counselors?id_user=".$request->id_user;
            $client = new Client();
            $response = $client->post($url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $session_token,
                    'Content-Type' => 'application/json',
                ],
            ]);
            $statusCode = $response->getStatusCode();
            if($statusCode != 200){
                session()->flash('danger', 'Gagal menambahkan konselor');
                return redirect()->back();
            }else{
                session()->flash('success', 'Sukses menambahkan konselor');
                return redirect()->back();
            }
        }catch (GuzzleHttp\Exception\RequestException $e) {
            // Handle any exceptions or errors that might occur during the request.
            // For example, if the request failed or the endpoint returned an error status code.
        }

    }
    public function show($id)
    {
        $counselor = User::where('_id', $id)->first();
        $pasien = User::where('tbc.counselor', $id)->get();
        $users = User::OrderBy('nama.nama_depan', 'ASC')->get();
        $data = [
            "title"         => "Counselor",
            "class"         => "user",
            "sub_class"     => "counselor",
            "content"       => "layout.user",
            "counselor"     => $counselor,
            "user"          => Auth::user(),
            "users"         => $users,
            "pasien"        => $pasien
        ];
        return view('user.counselor.show', $data);
    }
    public function destroy($id)
    {
        $counselor = User::where('_id', $id)->first();
        $update = $counselor->update([
            'counselor'     => false
        ]);
        session()->flash('success', 'Sukses menhapus konselor');
        return redirect()->back();
    }
}
