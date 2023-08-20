<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Code;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CodeController extends Controller
{
    public function index(){
        $code = Code::all();
        $data = [
            "title"         => "Data Code",
            "class"         => "code all",
            "sub_class"     => "Get All",
            "content"       => "layout.admin",
            "code"          => $code,
        ];
        return view('admin.code.vital-sign.index', $data);
    }
    public function create()
    {
        $category = Code::all();
        $code = new Code();
        $data = [
            "title"         => "Data Code",
            "class"         => "code",
            "sub_class"     => "create",
            "content"       => "layout.admin",
            "code"          => $code,
            "category"      => $category
        ];
        return view('admin.code.create', $data);
    }
    public function store(Request $request)
    {
        $session_token  = decrypt(session('web_token'));
        $validator      = Validator::make($request->all(), [
            'code'      => 'required|unique:codes,code',
            'system'    => 'required',
            'display'   => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }else{
            $url        = "https://dev.atm-sehat.com/api/v1/codes";
            $header = [
                'Authorization' => "Bearer $session_token",
            ];
            $client     = new Client();
            $response   = $client->post($url, [
                'headers' => $header,
                'form_params' => [
                    'code'      => $request->code,
                    'system'    => $request->system,
                    'display'   => $request->display,
                    'category'  => $request->category
                ]
            ]);
            $statusCode = $response->getStatusCode();
            if($statusCode == 201){
                session()->flash('success', 'Success, data saved');
                return redirect()->back();
            }
//            $category_db = Code::where('code',$request->category)->first();
//            $category = [
//                'code'      => $category_db->code,
//                'system'    => $category_db->system,
//                'display'   => $category_db->display
//            ];
//            $input      = [
//                'code'      => $request->code,
//                'system'    => $request->system,
//                'display'   => $request->display,
//                'category'  => $category
//            ];
//
//            $code       = new Code();
//            $create     = $code->insert($input);
//            if($create){
//                session()->flash('success', 'Success, data saved');
//                return redirect()->back();
//            }
        }
    }
    public function show($id)
    {
        $category = Code::all();
//        dd($category);
        $code = Code::find($id);
        $data = [
            "title"         => "Data Code",
            "class"         => "code",
            "sub_class"     => "show",
            "content"       => "layout.admin",
            "code"          => $code,
            "category"      => $category
        ];
        return view('admin.code.show', $data);
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'code'      => 'required',
            'system'    => 'required',
            'display'   => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }else{
            $category_db = Code::where('code',$request->category)->first();
            $category = [
                'code'      => $category_db->code,
                'system'    => $category_db->system,
                'display'   => $category_db->display
            ];
            $input      = [
                'code'      => $request->code,
                'system'    => $request->system,
                'display'   => $request->display,
                'category'  => $category
            ];
//            dd($request->category);
            $code       = Code::find($id);
            $create     = $code->update($input);
            if($create){
                session()->flash('success', 'Success code updated');
                return redirect()->back();
            }
        }
    }
}
