<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FotoController extends Controller
{
    public function store(Request $request)
    {
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $result     = Storage::disk('s3')->putFileAs('image', $file, $file->hashName(),'public');
            $url        = Storage::disk('s3')->url($result);
            $data_file  = [
                'name'      => $file->hashName(),
                'extention' => $file->getClientOriginalExtension(),
                'mimeType'  => $file->getClientMimeType(),
                'size'      => $file->getSize(),
                'user_id'   => Auth::id(),
                'url'       => $url
            ];
            if(!empty($url)){
                $create_file = new File();
                $save = $create_file->create($data_file);
                if($save){
                    $status_code    = 200;
                    $message        = "Success File Saved";
                    $data = [
                        'file' => $url,
                    ];
                }
            }
            $response = [
                'status_code'   => $status_code,
                'message'       => $message,
                'data'          => $data
            ];
            return response()->json($response, $status_code);
        }else{
            echo "Gagal";
        }
    }
}
