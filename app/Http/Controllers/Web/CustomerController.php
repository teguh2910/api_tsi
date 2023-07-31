<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Kit;

class CustomerController extends Controller
{
    public function index() {
        $customers = Customer::all();
        $data = [
            "title"         => "List Customers",
            "class"         => "customer",
            "sub_class"     => "list",
            "content"       => "layout.admin",
            "customers"     => $customers
        ];
        return view('user.customer.index', $data);
    }
    public function show($id)
    {
        $customer   = Customer::where('_id', $id)->first();
        $kits       = Kit::where('owner.code', $customer->code)->get();
        $data = [
            "title"         => "List Customers",
            "class"         => "customer",
            "sub_class"     => "list",
            "content"       => "layout.admin",
            "customer"      => $customer,
            "kits"          => $kits
        ];

        return view('user.customer.show', $data);
    }
}
