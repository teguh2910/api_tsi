<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Drug;
use App\Models\Education;
use App\Models\Marital_status;
use App\Models\Medication;
use App\Models\Observation;
use App\Models\Religion;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function profile()
    {
        $url        = "https://dev.atm-sehat.com/api/v1/over-view/latest";
        $client     = new Client();
        $session_token = decrypt(session('web_token'));
//        dd($session_token);
        $header = [
            'Authorization' => "Bearer $session_token",
        ];
        $response   = $client->get($url, [
            'headers'       => $header
        ]);
        $data = json_decode($response->getBody());
//        dd($data->data);
        $user           = Auth::user();
        $observation    = Observation::where('id_pasien', Auth::id())->orderBy('time', 'DESC');
        $family         = User::where('family.id_induk', Auth::id())->get();
        $data = [
            "title"         => "Profile",
            "class"         => "user",
            "sub_class"     => "profile",
            "content"       => "layout.user",
            "user"          => $user,
            "observation"   => $observation->get(),
            "family"        => $family,
            "resume"        => $data->data,
        ];
        return view('user.profile.profile', $data);
    }
    public function edit()
    {
        $user               = Auth::user();
        $pendidikan         = Education::all();
        $agama              = Religion::all();
        $marital_status     = Marital_status::all();
        $data = [
            "title"         => "Profile",
            "class"         => "user",
            "sub_class"     => "profile",
            "content"       => "layout.user",
            "user"          => $user,
            "pendidikan"    => $pendidikan,
            "agama"         => $agama,
            "marital_status"=> $marital_status,
            "gender"        => ['male', 'female']
        ];
        return view('user.profile.edit', $data);
    }
    public function user($id)
    {
        $user           = User::find($id);
        $observation    = Observation::where('id_pasien', $id)->orderBy('time', 'DESC');
        $medication     = Medication::where('pasien.id', $id)->orderBy('created_at', 'DESC');
        $drug           = Drug::all();
        $data = [
            "title"         => "Profile",
            "class"         => "user",
            "sub_class"     => "profile",
            "content"       => "layout.user",
            "user"          => $user,
            "observation"   => $observation->get(),
            "medication"    => $medication->get(),
            "drugs"         => $drug
        ];
        return view('user.profile.profile', $data);
    }
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_depan'    => 'required',
            'nama_belakang' => 'required',
            'gender'        => 'required',
            'tanggal_lahir' => 'required',
            'tempat_lahir'  => 'required',
            'pendidikan'    => 'required',
            'agama'         => 'required',
            'status_menikah'=> 'required',
            'warga_negara'  => 'required',
            'suku'          => 'required',


        ]);
//        dd($request->all());
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }else{
            $user = Auth::user();
            $request->nama_depan != null ? $nama_depan = $request->nama_depan : $nama_depan = $user->nama['nama_depan'];
            $request->nama_belakang != null ? $nama_belakang = $request->nama_belakang : $nama_belakang = $user->nama['nama_belakang'];
            $request->gender != null ? $gender = $request->gender : $gender = $user->gender;
            $request->tanggal_lahir != null ? $tanggal_lahir = $request->tanggal_lahir : $tanggal_lahir = $user->tanggal_lahir;
            $request->tempat_lahir != null ? $tempat_lahir = $request->tempat_lahir : $tempat_lahir = $user->tempat_lahir;
            if($request->pendidikan != null){
                $data_pendidikan = Education::find($request->pendidikan);
                $pendidikan = [
                    'kode'  => $data_pendidikan->kode,
                    'pendidikan'    => $data_pendidikan->pendidikan
                ];
            }else{
                $pendidikan = $user->pendidikan;
            }
            if($request->agama != null){
                $data_agama = Religion::where('name', $request->agama)->first();
                $agama = [
                    'id'    => $data_agama->id,
                    'name'  => $data_agama->name
                ];
            }else{
                $agama = $user->agama;
            }
            if($request->status_menikah != null){
                $data_status_menikah = Marital_status::where('code',$request->status_menikah)->first();
                $status_menikah = [
                    'code'      =>  $data_status_menikah->code,
                    'display'   => $data_status_menikah->display
                ];
            }else{
                $status_menikah = $user->status_menikah;
            }
            $data_update = [
                "nama.nama_depan"   => $nama_depan,
                "nama.nama_belakang"=> $nama_belakang,
                "gender"            => $gender,
                "lahir.tanggal"     => $tanggal_lahir,
                "lahir.tempat"      => $tempat_lahir,
                "pendidikan"        => $pendidikan,
                "agama"             => $agama,
                "status_menikah"    => $status_menikah,
                "suku"              => $request->suku
            ];
//            dd($data_update);
            $update = $user->update($data_update);
            session()->flash('success', 'Profile berhasil diupdate');
            return redirect()->back();
        }
    }
    public function update_foto(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file'  => 'required|mimes:jpg,bmp,png|max:1000',
        ]);
//        dd($request->all());
        if ($validator->fails()) {
            session()->flash('danger', "Gagal Validasi");
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }else{
            $photo = $request->file('file');
            // Upload the photo using Guzzle
            $client = new Client();
            $apiEndpoint = 'https://file.atm-sehat.com/api/profile/foto'; // Replace with your API endpoint
            $session_token  = decrypt(session('web_token'));
            $header = [
                'Authorization' => "Bearer $session_token",
            ];

            try {
                $response = $client->post($apiEndpoint, [
                    'headers'   => $header,
                    'multipart' => [
                        [
                            'name'     => 'file', // Name of the parameter in the API that expects the photo
                            'contents' => fopen($photo->getPathname(), 'r'), // Open the photo in read mode and send it
                            'filename' => $photo->getClientOriginalName(), // Use the original file name
                        ],
                    ],
                ]);

                // Handle the response if needed
                $statusCode = $response->getStatusCode();
                $responseData = json_decode($response->getBody(), true);

                // Perform any other actions with the response data
                // ...
                session()->flash('success', $responseData['message']);
                return redirect()->back();

            } catch (\Exception $e) {
                // Handle the error if an exception occurs
                \Log::error('Error uploading photo: ' . $e->getMessage());
                session()->flash('danger', 'Gagal Upload');
                return redirect()->back();
            }
        }
    }
}
