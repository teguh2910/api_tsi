<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'nama.nama_depan'       => 'required',
            'nama.nama_belakang'    => 'required',
            'gender'                => 'required',
            'nik'                   => 'required|numeric',
            'kontak.email'          => 'required|email:rfc,dns|unique:users,kontak.email',
            'kontak.nomor_telepon'  => 'required|unique:users,kontak.nomor_telepon',
            'username'              => 'required|unique:users,username'
        ];
    }
}
