<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Religion;
use Illuminate\Http\Request;

class ReligionController extends Controller
{
    public function index ()
    {
        $religion = Religion::all();
        return response()->json([
            'status_code'   => 200,
            'message'       => 'success',
            'data'          => [
                "religion"    => $religion
            ],
        ]);
    }
}
