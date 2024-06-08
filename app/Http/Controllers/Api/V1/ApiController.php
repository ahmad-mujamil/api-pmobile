<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetUserRequest;
use App\Http\Requests\RegistrasiUserRequest;
use App\Http\Requests\UpdateProfileUserRequest;
use App\Http\Resources\UserRegistrasiResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserUpdateResource;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


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
        return UserResource::collection($users);
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

    public function login(GetUserRequest $request)
    {
        $user = User::query()
            ->where('nim',$request->nim)
            ->first();
        if(is_null($user))
            return $this->userNotFound();

        if(!Hash::check($request->password,$user->password))
            return $this->invalid("Password Salah",401);

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


    public function updateProfile(UpdateProfileUserRequest $request,User  $user)
    {
        try {
            DB::beginTransaction();
            $user->update(Arr::except($request->validated(),'foto'));
            if($request->hasFile('foto')){
                $foto = $request->file('foto');
                $filename = $user->nim.'.'.$foto->extension();
                $foto->storeAs('public/foto',$filename);
                $user->update(["foto" => $filename]) ;
            }
            DB::commit();
            return UserUpdateResource::make($user);
        }catch (\Exception $e){
            return $this->invalid($e->getMessage());
        }

    }


}
