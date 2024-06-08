<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegistrasiUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            "nim" => ["required",'string'],
            "nama" => ["required",'string'],
            "email" => ["required",'email'],
            "password" => ["required",'string'],
        ];
    }

    public function messages()
    {
        return [
            "nim.required" => "NIM tidak boleh kosong",
            "nama.required" => "Nama tidak boleh kosong",
            "password.required" => "Password tidak boleh kosong",
            "email.required" => "Email tidak boleh kosong",
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'data' => null,
            'message' => $validator->errors()->first()
        ], 422));
    }
}
