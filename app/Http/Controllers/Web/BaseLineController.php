<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\BaseLine;

class BaseLineController extends Controller
{
    public function index(){
        $base_line = BaseLine::all();
        $data = [
            "title"         => "Base Line",
            "class"         => "Base Line",
            "sub_class"     => "Get All",
            "content"       => "layout.admin",
            "base_line"     => $base_line,
        ];
        return view('admin.base_line.index', $data);
    }
}
