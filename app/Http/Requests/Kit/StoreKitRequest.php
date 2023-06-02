<?php

namespace App\Http\Requests\Kit;

use Illuminate\Foundation\Http\FormRequest;

class StoreKitRequest extends FormRequest
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
            'code'  => 'required|unique:kits,code',
            'name'  => 'required',
            'owner' => 'required',
            'distributor'   => 'required'
        ];
    }
}
