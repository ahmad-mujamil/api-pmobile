<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginUserRequest extends FormRequest
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
            "nim" => ["required","exists:users,nim"],
            "password" => ["required","string"],
        ];
    }

    public function messages()
    {
        return [
            "nim.required" => "Nomor induk harus diisi",
            "nim.exists" => "Nomor Induk Mahasiswa tidak ditemukan",
            "password.required" => "Password harus diisi",
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'data' => null,
            'message' => $validator->errors()->first('nim')
        ], 422));
    }
}
