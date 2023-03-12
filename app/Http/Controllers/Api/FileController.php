<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\File;
use Exception;
use Google\Cloud\Storage\StorageClient;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class FileController extends Controller
{
    public function store(Request $request){
        $file = $request->file('file');
        $file_meta = [
            'name'      => $file->getClientOriginalName(),
            'extention' => $file->getClientOriginalExtension(),
            'mimeType'  => $file->getClientMimeType(),
            'size'      => $file->getSize()
        ];
        $result = Storage::disk('s3')->putFileAs('image', $file, $file->hashName());
        $url    = Storage::disk('s3')->url($result);
        if(!empty($url)){
            return response()->json([
                'statsu_code'   => 201,
                'message'       => 'false',
                'content'       => [
                    'file_meta' => $file_meta,
                    'url'       => $url,
                ]
            ]);

        }



    }
    public function save(Request $request){
        $file       = $request->file('myfile');
        $filename   = $file->getClientOriginalName();
        $extension  = $file->getClientOriginalExtension();
        # If you set S3 as your default:
//        $contents = Storage::get('path/to/'.$filename);
//        Storage::put('path/to/file.ext', 'some-content');

        # If you do not have S3 as your default:
        $contents = Storage::disk('s3')->get('path/to/'.$filename);
        Storage::disk('s3')->put('path/to/'.$filename, 'some-content');
    }
}
