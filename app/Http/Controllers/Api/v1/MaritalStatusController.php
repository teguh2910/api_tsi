<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Marital_status;

class MaritalStatusController extends Controller
{
    public function index()
    {
        $marital_status = Marital_status::all();
        return response()->json([
           'status_code'    => 200,
           'message'        => 'success',
            'content'       => $marital_status
        ]);
    }
}
