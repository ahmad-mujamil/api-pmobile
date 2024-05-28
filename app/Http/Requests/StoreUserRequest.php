<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreUserRequest extends FormRequest
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
            "alamat" => ["required",'string'],
            "tgl_lahir" => ["required",'date'],
            "jurusan" => ["required",'string'],
            "email" => ["required",'email'],
        ];
    }

    public function messages()
    {
        return [
            "nim.required" => "NIM tidak boleh kosong",
            "nama.required" => "Nama tidak boleh kosong",
            "alamat.required" => "Alamat tidak boleh kosong",
            "tgl_lahir.required" => "Tanggal lahir tidak boleh kosong",
            "jurusan.required" => "Jurusan tidak boleh kosong",
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
