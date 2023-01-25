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

        if ($request->hasFile('myfile')) {
            try {
                $storage = new StorageClient([
                    'keyFilePath' => base_path('/service-account.json'),
                ]);

                $bucketName = env('GOOGLE_CLOUD_STORAGE_BUCKET');
                $bucket = $storage->bucket($bucketName);

                //get filename with extension
                $filenamewithextension = $request->file('myfile')->getClientOriginalName();

                //get filename without extension
                $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

                //get file extension
                $extension = $request->file('myfile')->getClientOriginalExtension();

                //filename to store
                $filenametostore = $filename.'_'.uniqid().'.'.$extension;

                Storage::put('public/uploads/'. $filenametostore, fopen($request->file('myfile'), 'r+'));

                $filepath = storage_path('app/public/uploads/'.$filenametostore);

                $object = $bucket->upload(
                    fopen($filepath, 'r'),
                    [
                        'predefinedAcl' => 'publicRead'
                    ]
                );

                // delete file from local disk
                Storage::delete('public/uploads/'. $filenametostore);

                return redirect('upload')->with('success', "File is uploaded successfully. File path is: https://storage.googleapis.com/$bucketName/$filenametostore");

            } catch(Exception $e) {
                echo $e->getMessage();
            }
        }
    }
}
