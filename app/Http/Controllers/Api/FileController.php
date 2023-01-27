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
        $filepath = public_path()."/".'suku.csv';
        $filename = 'suku.csv';
        Storage::disk('google')->put($filename, File::get($filepath));

        return response()->json([
            'statsu_code'   => 404,
            'message'       => 'false',
            'content'       => [
                'file'      => $filename,
                'name'      => $request->nama,

            ]
        ]);

    }
}
