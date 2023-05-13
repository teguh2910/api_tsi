<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Observation;
use Illuminate\Http\Request;

class ObservationController extends Controller
{
    public function index(){
        $observation = Observation::all();
        $data = [
            "title"         => "Observation",
            "class"         => "Observation",
            "sub_class"     => "Get All",
            "content"       => "layout.admin",
            "observation"   => $observation,
        ];
        return view('admin.observation.vital-sign.index', $data);
    }
}
