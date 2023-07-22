<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Question;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AnswerController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'question_id'   => 'required',
            'answer'        => 'required',
        ]);
        $question = Question::find($request->question_id);

        if ($validator->fails()) {
            return redirect()->route('questionnaire.show', ['id'=>$question->questionnaire['id']])
                ->withErrors($validator)
                ->withInput();
        }else{
            $data_post = [
                'question_id'=> $request->question_id,
                'answer'     => $request->answer,
            ];
            $session_token  = decrypt(session('web_token'));
            $url            = env('APP_API_EXTERNAL'). "/api/v1/answer";
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
                return redirect()->route('questionnaire.show', ['id'=>$question->questionnaire['id']]);
            }else{
                return redirect()->route('questionnaire.show', ['id'=>$question->questionnaire['id']]);
            }
        }
    }

}
