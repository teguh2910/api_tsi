<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Kuesioner;
use App\Models\Questionnaire;
use App\Models\Question;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class QuestionController extends Controller
{
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'questionnaire_id'  => 'required'
        ]);
        if ($validator->fails()) {
            $status_code    = 422;
            $message        = "Gagal Validasi";
            $data = [
                'errors' => $validator->errors(),
            ];
        }else{
            $kuesioner = Questionnaire::where('_id', $request->questionnaire_id);
            if($kuesioner->count() < 1){
                $status_code    = 404;
                $message        = "Not Found";
                $data = [
                    'count'     => $kuesioner->count(),
                    'kuesioner' => $kuesioner->get(),
                ];
            }else{
                $questions      = Question::where('kuesioner.id', $request->questionnaire_id);
                $status_code    = 200;
                $message        = "success";
                $data = [
                    'count'     => $questions->count(),
                    'questions' => $questions->get(),
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
            'questionnaire_id'  => 'required',
            'question'          => 'required',
            'tipe_jawaban'      => 'required', Rule::in(['isian', 'pilihan ganda', 'ceklis']),
        ]);
        if ($validator->fails()) {
            $status_code    = 422;
            $message        = "Gagal Validasi";
            $data = [
                'errors' => $validator->errors(),
            ];
        }else{
            $questionnaire = Questionnaire::where('_id', $request->questionnaire_id)->first();
            $data_question = [
                'questionnaire' => $questionnaire,
                'question'      => $request->question,
                'tipe_jawaban'  => $request->tipe_jawaban
            ];
            $question   = new Question();
            $create     = $question->create($data_question);
            if($create){
                $status_code    = 200;
                $message        = "success";
                $data = [
                    'question' => $data_question,
                ];
            }else{
                $status_code    = 204;
                $message        = "Un success";
                $data = [
                    'question' => $data_question,
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
    public function update()
    {
        echo "update";
    }
}
