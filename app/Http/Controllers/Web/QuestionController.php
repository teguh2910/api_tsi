<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QuestionController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'questionnaire_id'  => 'required',
            'question'          => 'required',
            'tipe_jawaban'      => 'required',
            'bobot'             => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->route('questionnaire.show', ['id'=>$request->questionnaire_id])
                ->withErrors($validator)
                ->withInput();
        }else{
            $data_post = [
                'questionnaire_id'  => $request->questionnaire_id,
                'question'          => $request->question,
                'tipe_jawaban'      => $request->tipe_jawaban,
                'bobot'             => $request->bobot
            ];
            $session_token  = decrypt(session('token'));
            $url        = "https://dev.atm-sehat.com/api/v1/questions";
            $header = [
                'Authorization' => "Bearer $session_token",
            ];
            $client     = new Client();
            $response   = $client->post($url, [
                'headers'       => $header,
                'form_params'   => $data_post
            ]);
            $statusCode = $response->getStatusCode();
            if($statusCode == 200){
                return redirect()->route('questionnaire.show',['id'=>$request->questionnaire_id]);
            }else{
                dd($statusCode);
            }
        }
    }
}
