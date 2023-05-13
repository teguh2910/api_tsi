<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Code;
use Illuminate\Http\Request;

class CodeController extends Controller
{
    public function index(){
        $code = Code::all();
        $data = [
            "title"         => "Data Code",
            "class"         => "code all",
            "sub_class"     => "Get All",
            "content"       => "layout.admin",
            "code"          => $code,
        ];
        return view('admin.code.vital-sign.index', $data);
    }
}
