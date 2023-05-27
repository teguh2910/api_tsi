<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Marital_status;
use App\Models\Observation;
use Illuminate\Http\Request;

class ObservationController extends Controller
{
    public function index(){
        $bservation = Observation::orderBy('time', 'DESC')->paginate(5);
        $data = [
            "title"             => "Marital Status",
            "class"             => "Marital Status",
            "sub_class"         => "Get All",
            "content"           => "layout.admin",
            "observation"       => $bservation,
        ];
        return view('admin.observation.vital-sign.index', $data);
    }
}
