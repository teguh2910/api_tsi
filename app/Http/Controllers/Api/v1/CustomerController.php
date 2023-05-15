<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::all();
        return response()->json([
            "status_code"   => 200,
            "message"       => "success",
            "time"          => time(),
            "data"          => [
                'count'     => Customer::count(),
                'customers' => $customers
            ]
        ],203);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator              = Validator::make($request->all(), [
            'customer_code'     => 'required|unique:customers,code',
            'customer_name'     => 'required',
            'customer_pic'      => 'required',
            'email'             => 'required|unique:customers,email|email',
            'hp'                => 'required|unique:customers,hp|numeric',
            'alamat'            => 'required'
        ]);
        $customer_code  = $request->customer_code;
        $customer_name  = $request->customer_name;
        $customer_pic   = $request->customer_pic;
        $email          = $request->email;
        $hp             = $request->hp;
        $alamat         = $request->alamat;

        if ($validator->fails()){
            $status_code = 422;
            $data = [
                "status_code"   => $status_code,
                "message"       => "Gagal validasi",
                "data"      => [
                    "error"     => $validator->errors()
                ]
            ];
            return response()->json($data,$status_code);
        }
        $input      = [
            'code'      => $customer_code,
            'name'      => $customer_name,
            'pic'       => $customer_pic,
            'email'     => $email,
            'hp'        => $hp,
            'alamat'    => $alamat

        ];
        $customer = new Customer();
        $add = $customer->create($input);
        if($add){
            $status_code = 201;
            $data = [
                "status_code"   => $status_code,
                "message"       => "SUccess",
                "data"      => [
                    "customers"     => $input
                ]
            ];
            return response()->json($data,$status_code);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator              = Validator::make($request->all(), [
            'customer_code'     => 'required',
            'customer_name'     => 'required',
            'customer_pic'      => 'required',
            'email'             => 'required|email',
            'hp'                => 'required|numeric',
            'alamat'            => 'required'
        ]);
        $customer_code  = $request->customer_code;
        $customer_name  = $request->customer_name;
        $customer_pic   = $request->customer_pic;
        $email          = $request->email;
        $hp             = $request->hp;
        $alamat         = $request->alamat;
        $customer       = Customer::where('code', $customer_code)->first();
        if ($validator->fails()){
            $status_code = 422;
            $data = [
                "status_code"   => $status_code,
                "message"       => "Gagal validasi",
                "data"      => [
                    "error"     => $validator->errors()
                ]
            ];
            return response()->json($data,$status_code);
        }
        $input      = [
            'code'      => $customer_code,
            'name'      => $customer_name,
            'pic'       => $customer_pic,
            'email'     => $email,
            'hp'        => $hp,
            'alamat'    => $alamat

        ];

        $update = $customer->update($input);
        if($update){
            $status_code = 200;
            $data = [
                "status_code"   => $status_code,
                "message"       => "SUccess",
                "data"      => [
                    "customers"     => $input
                ]
            ];
            return response()->json($data,$status_code);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer   = Customer::find($id);
        if(empty($customer)){
            $status_code = 404;
            $data = [
                "status_code"   => $status_code,
                "message"       => "Not Found",
                "data"      => [
                    "customers"     => $customer
                ]
            ];
            return response()->json($data,$status_code);
        }
        $delete     = $customer->delete();
        if($delete){
            $status_code = 200;
            $data = [
                "status_code"   => $status_code,
                "message"       => "Success",
                "data"      => [
                    "customers"     => "Deleted"
                ]
            ];
            return response()->json($data,$status_code);
        }
    }
}
