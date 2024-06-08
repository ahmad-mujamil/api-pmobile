<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateProfileUserRequest extends FormRequest
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
            "foto" => "nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048",
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
            "email.required" => "Jurusan tidak boleh kosong",
            "foto" => "tidak sesuai format atau ukuran file",

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
