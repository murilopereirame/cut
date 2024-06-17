<?php

namespace App\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UnlockRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'code' => 'required|string',
            'passphrase' => 'required|string'
        ];
    }

    public function failedValidation(Validator $validator)
    {

        throw new HttpResponseException(response()->json([
            "status" => "ERROR",
            "message" => "Campo(s) inválido(s).",
            'data' => $validator->errors()
        ], 400));
    }
}
