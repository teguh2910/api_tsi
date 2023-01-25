<?php

namespace App\Http\Requests\user;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'nama_depan'        => 'required',
            'nama_belakang'     => 'required',
            'gelar_depan'       => 'required',
            'gelar_belakang'    => 'required',
            'gender'            => 'required',
            'nik'               => 'required|numeric|digits:16',
            'nomor_telepon'     => 'required|numeric|digits_between:10,13',
            'email'             => 'required|email:rfc,dns',
            'place_birth'       => 'required',
            'birth_date'        => 'required|date',
            'status_menikah'    => 'required',

        ];
    }
}
