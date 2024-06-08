<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Cache;

class UserRegistrasiResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        $token = $this->createToken($this->nim)->plainTextToken;

        return [
            "nim" => $this->nim,
            "nama" => $this->nama,
            "jurusan" => $this->jurusan,
            "email" => $this->email,
            "token" => $token,

        ];
    }
}
