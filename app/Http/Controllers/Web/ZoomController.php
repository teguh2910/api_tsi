<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use App\Models\User;
use Illuminate\Http\Request;

class ZoomController extends Controller
{
    public function index()
    {

    }
    public function counselor($id)
    {
        $counselor = User::where([
            '_id'       => $id,
            'counselor' => true
        ])->first();
    }
    public function meeting($id)
    {
        $meeting = Meeting::where([
            '_id'       => $id,
            'status'    => '!=', 'closed'
        ])->first();
    }
}
