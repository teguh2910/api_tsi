<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\File;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function index(Request $request)
    {
        if(! empty($request->type) )  {
            if($request->type == 'image'){
                $files = File::whereIn('extention', ['jpg', 'jpeg'])->get();
            }elseif ($request->type == 'image'){
                $files = File::whereIn('extention', ['jpg', 'jpeg'])->get();
            }
            $type = $request->type;

        }else{
            $type = "Get All";
            $files = File::all();
        }

        $data = [
            "title"     => "File List",
            "class"     => "File",
            "sub_class" => $type,
            "content"   => "layout.admin",
            "files"      => $files
        ];
        return view('admin.file.index', $data);
    }

}
