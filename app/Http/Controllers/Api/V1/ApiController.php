<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetUserRequest;
use App\Http\Requests\RegistrasiUserRequest;
use App\Http\Requests\UpdateProfileUserRequest;
use App\Http\Resources\UserRegistrasiResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;


class ApiController extends Controller
{

    public function index () {

        return response()->json([
            "name" => "Api Endpoint Pemerograman Mobile 2",
            "version" => "v1"
        ]);
    }

    public function getAllUser(Request $request)
    {
        $users = User::all();
        return UserResource::make($users);
    }


    public function getUserByNim(GetUserRequest $request)
    {
        $user = User::query()
            ->where('nim',$request->nim)
            ->first();
        if(is_null($user))
            return $this->userNotFound();

        if(is_null($request->nim))
            return $this->invalid();

        return UserResource::make($user);
    }

    public function registrasi(RegistrasiUserRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = User::query()->create($request->validated());
            DB::commit();
            return UserRegistrasiResource::make($user);
        }catch (\Exception $e){
            return $this->invalid($e->getMessage());
        }

    }


    public function updateProfile(UpdateProfileUserRequest $request, User $user)
    {
        try {
            DB::beginTransaction();
            $user->update(Arr::except($request->validated(),'foto'));
            if($request->hasFile('foto')){
                $foto = $request->file('foto');
                $foto->storeAs('public/foto',$user->nim.'.'.$foto->extension());
                $user->foto = $user->nim.'.'.$foto->extension();
                $user->save();
            }
            DB::commit();
            return UserResource::make($user);
        }catch (\Exception $e){
            return $this->invalid($e->getMessage());
        }

    }


}
