<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Questionnaire;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QuestionnaireController extends Controller
{
    public function index()
    {
        $questionnaire = Questionnaire::all();
        $data = [
            "title"         => "Video Conference",
            "class"         => "Marital Status",
            "sub_class"     => "Get All",
            "content"       => "layout.admin",
            "questionnaire" => $questionnaire
        ];
        return view('admin.questionnaire.index', $data);
    }
    public function create()
    {
//        $questionnaire = Questionnaire::find($id);
        $data = [
            "title"         => "Questionnaire",
            "class"         => "Marital Status",
            "sub_class"     => "Get All",
            "content"       => "layout.admin",
//            "questionnaire" => $questionnaire
        ];
        return view('admin.questionnaire.create', $data);
    }
    public function store(Request $request)
    {
        $session        = json_decode(decrypt(session('body')));
        $session_token  = $session->token->code;
        $token          = 'Bearer '.$session_token;
        $validator = Validator::make($request->all(), [
            'judul'             => 'required',
            'tanggal_mulai'     => 'required|date',
            'tanggal_selesai'   => 'required|date'
        ]);
        if ($validator->fails()) {
            return redirect()->route('questionnaire.create')
                ->withErrors($validator)
                ->withInput();
        }else{
            $url        = "https://dev.atm-sehat.com/api/v1/questionnaire";
            $client = new Client();
            $response = $client->post($url, [
                'Authorization' => $token,
                'form_params' => [
                    'judul'             => $request->judul,
                    'tanggal_mulai'     => $request->tanggal_mulai,
                    'tanggal_selesai'   => $request->tanggal_selesai
                ]
            ]);
            $statusCode = $response->getStatusCode();
            $body = $response->getBody()->getContents();
            $json_decode = json_decode($body);
            if($statusCode == 200){
                return "created";
            }
        }

    }
}
