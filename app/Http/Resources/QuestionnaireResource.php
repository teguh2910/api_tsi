<?php

namespace App\Http\Resources;

use App\Models\Question;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionnaireResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $question = Question::where('questionnaire.id', $this->_id);
        return [
            'id'      => $this->_id,
            'judul'    => $this->judul,
            'question'   => $question->count()
        ];
    }
}
