<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\QuestionnaireResource;
use App\Models\Question;
use App\Models\Questionnaire;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QuestionnaireController extends Controller
{
    public function index()
    {
        $questionnaire = QuestionnaireResource::collection(Questionnaire::all()) ;
        $data = [
            "title"         => "Questionnaire",
            "class"         => "Marital Status",
            "sub_class"     => "Get All",
            "content"       => "layout.admin",
            "questionnaire" => $questionnaire
        ];
        return view('admin.questionnaire.index', $data);
    }
    public function create()
    {
        $data = [
            "title"         => "Questionnaire",
            "class"         => "Marital Status",
            "sub_class"     => "Get All",
            "content"       => "layout.admin"
        ];
        return view('user.questionnaire.create', $data);
    }
    public function store(Request $request)
    {
        $session        = json_decode(decrypt(session('body')));
        $session_token  = $session->token->code;
        $token          = 'Bearer '.$session_token;
//        dd($token);
        $validator = Validator::make($request->all(), [
            'judul'             => 'required',
            'tanggal_mulai'     => 'required|date',
            'tanggal_selesai'   => 'required|date',
            'status'            => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->route('questionnaire.create')
                ->withErrors($validator)
                ->withInput();
        }else{
            $url        = "https://dev.atm-sehat.com/api/v1/questionnaire";
            $header = [
                'Authorization' => "Bearer $session_token",
            ];
            $client     = new Client();
            $response   = $client->post($url, [
                'headers' => $header,
                'form_params' => [
                    'judul'             => $request->judul,
                    'tanggal_mulai'     => $request->tanggal_mulai,
                    'tanggal_selesai'   => $request->tanggal_selesai,
                    'status'            => $request->status
                ]
            ]);
            $statusCode = $response->getStatusCode();
            if($statusCode == 201){
                return redirect()->route('questionnaire.index');
            }
        }

    }
    public function show($id)
    {
        $questionnaire = Questionnaire::find($id);
        $question = Question::where('questionnaire.id', $id);
        $data = [
            "title"         => "Questionnaire",
            "class"         => "Marital Status",
            "sub_class"     => "Get All",
            "content"       => "layout.admin",
            "questionnaire" => $questionnaire,
            "question"=>$question->get()
        ];
        return view('admin.questionnaire.show', $data);
    }
    public function publish()
    {
        $questionnaire = Questionnaire::where('status', 'publish')->get();
        $data = [
            "title"         => "Questionnaire",
            "class"         => "Marital Status",
            "sub_class"     => "Get All",
            "content"       => "layout.admin",
            "questionnaire" => $questionnaire
        ];
        return view('user.questionnaire.index', $data);
    }
    public function showByuser($id)
    {
        $questionnaire = Questionnaire::find($id);
        $question = Question::where('questionnaire.id', $id);
        $data = [
            "title"         => "Questionnaire",
            "class"         => "Marital Status",
            "sub_class"     => "Get All",
            "content"       => "layout.admin",
            "questionnaire" => $questionnaire,
            "question"=>$question->get()
        ];
        return view('user.questionnaire.show', $data);
    }
}
