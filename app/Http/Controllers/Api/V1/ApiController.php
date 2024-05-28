<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetLppByNomorRequest;
use App\Http\Requests\GetLppRequest;
use App\Http\Requests\GetUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\LppResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\LogPaymentServices;
use App\Services\RekeningServices;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;


class ApiController extends Controller
{

    public function index () {

        return response()->json([
            "name" => "Api Endpoint Pemerograman Mobile",
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


    public function storeUser(StoreUserRequest $request)
    {
        try {
            DB::transaction();
            $user = User::query()->create($request->validated());
            DB::commit();
            return UserResource::make($user);
        }catch (\Exception $e){
            LogPaymentServices::createLog($request,"error",$e->getMessage());
            return $this->invalid($e->getMessage());
        }

    }


}
