<?php

namespace App\Http\Resources;

use App\Models\TnpDenda;
use App\Services\RekeningServices;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Cache;

class UserResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            "nim" => $this->nim,
            "nama" => $this->nama,
            "alamat" => $this->alamat,
            "tgl_lahir" => $this->tgl_lahir,
            "jurusan" => $this->jurusan,

        ];
    }
}
