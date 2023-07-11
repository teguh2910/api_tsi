<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AnswerController extends Controller
{
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'question_id'  => 'required'
        ]);
        if ($validator->fails()) {
            $status_code    = 422;
            $message        = "Gagal Validasi";
            $data = [
                'errors' => $validator->errors(),
            ];
        }else{
            $question = Question::where('_id', $request->question_id);
            if($question->count() < 1 ){
                $status_code    = 404;
                $message        = "Wrong question_id";
                $data = [
                    'questions' => ''
                ];
            }else{
                $answer = Question::find($request->question_id)->answer;

                $status_code    = 200;
                $message        = "success";
                $data = [
                    'answer' => $answer
                ];
            }

        }
        $data_json = [
            "status_code"   => $status_code,
            "message"       => $message,
            "data"          => $data
        ];
        return response()->json($data_json, $status_code);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'question_id'  => 'required',
            'answer'    => 'required'
        ]);
        if ($validator->fails()) {
            $status_code    = 422;
            $message        = "Gagal Validasi";
            $data = [
                'errors' => $validator->errors(),
            ];
        }else{
            $question   = Question::where('_id', $request->question_id);
            if($question->count() < 1){
                $status_code    = 422;
                $message        = "Wrong question id";
                $data = [];
            }else{
                $db_answer = Answer::where([
                    'answer'        => $request->answer,
                    'question.id'   => $request->question_id
                ]);
                if($db_answer->count()>0){
                    $status_code    = 422;
                    $message        = "Jawaban tidak boleh sama dalam satu pertanyaan";
                    $data = [];
                }else{

                    if(empty($request->is_answer)){
                        $is_answer = false;
                    }else{
                        $is_answer = $request->is_answer;
                    }
                    $data_answer = [
                        'question'  => [
                            'id'        => $question->first()['_id'],
                            'question'  => $question->first()['question']
                        ],
                        'answer'    => $request->answer,
                        'is_answer' => $is_answer
                    ];
                    $answer = new Answer();
                    $create = $answer->create($data_answer);
                    if($create){
                        $status_code    = 200;
                        $message        = "success";
                        $data = [
                            'answer' => $request->answer,
                        ];
                    }else{

                    }

                }


            }

        }
        $data_json = [
            "status_code"   => $status_code,
            "message"       => $message,
            "data"          => $data
        ];
        return response()->json($data_json, $status_code);
    }
}
