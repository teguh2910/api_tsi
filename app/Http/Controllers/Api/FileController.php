<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FileController extends Controller
{
    public function index()
    {

    }
    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'file'  => 'required|image|size:2000',
        ]);
        if ($validator->fails()) {
            $status_code    = 422;
            $message        = "Gagal Validasi";
            $data = [
                'errors' => $validator->errors(),
            ];
        }else{
            $file = $request->file('file');
            $result     = Storage::disk('public')->putFileAs('image', $file, $file->hashName());
            $url        = Storage::disk('public')->url($result);
            $data_file  = [
                'name'      => $file->hashName(),
                'extention' => $file->getClientOriginalExtension(),
                'mimeType'  => $file->getClientMimeType(),
                'size'      => $file->getSize(),
                'user_id'   => Auth::id(),
                'url'       => url($url)
            ];
            if(!empty($url)){
                $create_file = new File();
                $save = $create_file->create($data_file);
                if($save){
                    $user = Auth::user();
                    $update = $user->update([
                        'foto'  => url($url)
                    ]);
                    $status_code    = 200;
                    $message        = "Foto Profile updated";
                    $data = [
                        'foto' => url($url),
                    ];
                }

            }
        }
        $response = [
            'status_code'   => $status_code,
            'message'       => $message,
            'data'          => $data
        ];
        return response()->json($response);
    }
    public function show(Request $request)
    {

    }


}
