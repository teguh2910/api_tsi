<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

class MessageController extends Controller
{
    public function index()
    {
        $data = [
            "title"             => "Marital Status",
            "class"             => "Marital Status",
            "sub_class"         => "Get All",
            "content"           => "layout.admin",
        ];
        return view('admin.message.index', $data);
    }
}
