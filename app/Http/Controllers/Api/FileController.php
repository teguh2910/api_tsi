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
        $path       = $request->file('myfile')->store('avatars');
        $file       = $request->file('myfile');
        $filename   = $file->hashName(); // Generate a unique, random name...
        $extension  = $file->extension();

        return response()->json([
            'statsu_code'   => 404,
            'message'       => 'false',
            'content'       => [
                'file'      => $filename,
                'name'      => $request->nama,
            ]
        ]);

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
