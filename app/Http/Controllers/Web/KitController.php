<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Kit\StoreKitRequest;
use App\Models\Customer;
use App\Models\Kit;
use App\Models\Religion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KitController extends Controller
{
    public function index(){
        $kit = Kit::all();
        $customer = Customer::all();
        $data = [
            "title"     => "Kits List",
            "class"     => "Kit",
            "sub_class" => "Get All",
            "content"   => "layout.admin",
            "kits"      => $kit,
            "customer"  => $customer
        ];
        return view('admin.kits.index', $data);
    }
    public function store(StoreKitRequest $request){
        $input      = $request->validated();
        $data_input = [
            'kit_code'          => $request->code,
            'kit_name'          => $request->name,
            'owner_code'        => $request->owner,
            'distributor_code'  => $request->distributor
        ];
        $data_json  = json_encode($data_input);
        $token          = 'Authorization: Bearer 645706809498aea6a30091c2|QJESpLWRUr1CRQTwjvYQ4L3ZiuCvirpyLQccCh3d';
        $url            = 'https://dev.atm-sehat.com/api/v1/kits';
        $method         = 'POST';
        $create         = json_decode($this->curl($token, $url, $method, $data_json)->original);

        if($create){
            return redirect()->route('kits.index')->with('success', 'Data berhasil disimpan');
        }
    }
    public function curl($token, $url, $method, $data){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL             => $url,
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_ENCODING        => '',
            CURLOPT_MAXREDIRS       => 10,
            CURLOPT_TIMEOUT         => 0,
            CURLOPT_FOLLOWLOCATION  => true,
            CURLOPT_HTTP_VERSION    => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST   => $method,
            CURLOPT_POSTFIELDS      => $data,
            CURLOPT_HTTPHEADER      => array('Content-Type: application/json', $token),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return response($response);
    }
}
