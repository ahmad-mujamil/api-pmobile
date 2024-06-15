<?php

namespace App\Http\Resources;

use App\Services\RekeningServices;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Cache;

class UserUpdateResource extends JsonResource
{

    public static $wrap = null;
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "nim" => $this->nim,
            "nama" => $this->nama,
            "alamat" => $this->alamat,
            "tgl_lahir" => $this->tgl_lahir,
            "jurusan" => $this->jurusan,
            "email" => $this->email,
            "foto" => !is_null($this->foto) ? asset('storage/foto/'.$this->foto) : null,
        ];
    }
}
