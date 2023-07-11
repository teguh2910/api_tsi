<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class FileController extends Controller
{
    public function index()
    {

    }
    public function store(Request $request){
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
            }
            return response()->json($data_file);
        }
    }
    public function show(Request $request)
    {

    }


}
