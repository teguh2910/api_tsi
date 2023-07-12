<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FileResource;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FileController extends Controller
{
    public function index()
    {
        $file = File::all();
        if(empty($file)){
            $status_code    = 404;
            $message        = "Not Found";
            $data           = [
                'files'     => $file
            ];
        }else{
            $status_code    = 200;
            $message        = "success";
            $data           = [
                'files'     => FileResource::collection($file)
            ];
        }
        $response = [
            'status_code'   => $status_code,
            'message'       => $message,
            'data'          => $data
        ];
        return response()->json($response);
    }
    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'file'  => 'required',
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
                    $status_code    = 200;
                    $message        = "File Uploaded";
                    $data = [
                        'file' => $data_file,
                    ];
                }else{
                    $status_code    = 422;
                    $message        = "Gagal Upload";
                    $data = [
                        'file' => $data_file,
                    ];
                }
            }else{
                $status_code    = 422;
                $message        = "Tidak ada gambar";
                $data = [
                    'file' => $data_file,
                ];
            }
        }
        $response = [
            'status_code'   => $status_code,
            'message'       => $message,
            'data'          => $data
        ];
        return response()->json($response);
    }
    public function profile(Request $request){
        $validator = Validator::make($request->all(),[
            'file'  => 'required|mimes:jpg,bmp,png|max:2000',
        ]);
        $file = $request->file('file');
        if ($file->getSize() > 200000) {
            $status_code    = 422;
            $message        = "Ukuran gambar terlalu besar";
            $data = [
                'errors' => $validator->errors(),
            ];
        }elseif($validator->fails()){
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
                        'foto'  => [
                            'url'       => url($url),
                            'name'      => $file->hashName(),
                            'extention' => $file->getClientOriginalExtension(),
                            'mimeType'  => $file->getClientMimeType(),
                            'size'      => $file->getSize(),
                        ]
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
        $validator = Validator::make($request->all(),[
            'file_name' => 'required',
            'key'       => 'required'
        ]);
        if ($validator->fails()) {
            $status_code    = 422;
            $message        = "Gagal Validasi";
            $data = [
                'errors' => $validator->errors(),
            ];
        }else{
            $file           = File::where([
                'name'  => $request->file_name,
                '_id'   => $request->key
            ])->first();
            if(empty($file)){
                $status_code    = 404;
                $message        = "Not Found";
                $data = [
                    'file' => $file,
                ];
            }else{
                $status_code    = 200;
                $message        = "success";
                $data = [
                    'file' => $file,
                ];
            }

        }
        $response = [
            'status_code'   => $status_code,
            'message'       => $message,
            'data'          => $data
        ];
        return response()->json($response);

    }
    public function showFotoProfile()
    {
        if(empty(Auth::user()['foto'])){
            $status_code    = 404;
            $message        = "Not Found";
            $data = [
                'file' => '',
            ];
            $response = [
                'status_code'   => $status_code,
                'message'       => $message,
                'data'          => $data
            ];
            return response($response);
        }else{
            $name       = Auth::user()['foto']['name'];
            $db_file    = File::where('name', $name)->first();
            $key        = $db_file->_id;
            $file       = $this->privateFile($name, $key, Auth::id())->getOriginalContent();
            return response($file);
        }


    }
    private function publicFile($name,$key)
    {
        $file   = File::where([
            'name'  => $name,
            '_id'   => $key
        ])->first();
        if(empty($file)){
            $status_code = 404;
            $message    = "Not Found";
            $data       = [
                'file'  => $file
            ];
        }else{
            $status_code = 200;
            $message    = "success";
            $data       = [
                'file'  => $file
            ];
        }
        $response = [
            'status_code'   => $status_code,
            'message'       => $message,
            'data'          => $data
        ];
        return response($response);

    }
    private function privateFile($name,$key,$user_id)
    {
        $file   = File::where([
            'name'      => $name,
            '_id'       => $key,
            'user_id'   => $user_id
        ])->first();
        if(empty($file)){
            $status_code = 404;
            $message    = "Not Found";
            $data       = [
                'file'  => $file
            ];
        }else{
            $status_code = 200;
            $message    = "success";
            $data       = [
                'file'  => $file
            ];
        }
        $response = [
            'status_code'   => $status_code,
            'message'       => $message,
            'data'          => $data
        ];
        return response($response);
    }
}
