<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\ApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(["prefix" => "v1", "as"=>"v1."],function() {
    Route::get('/', [ApiController::class, 'index'])->name('index');

    Route::post('/registrasi',[ApiController::class,'registrasi'])
        ->name('registrasi');

    Route::post('/login',[ApiController::class,'login'])
        ->name('login');

    Route::middleware(['auth:sanctum'])->group(function(){

        Route::get('get-user',[ApiController::class,'getAllUser'])
            ->name('get-user');

        Route::post('get-user-by-nim',[ApiController::class,'getUserByNim'])
            ->name('get-user-by-nim');

        Route::post('update-profile/{user}',[ApiController::class,'updateProfile'])
            ->name('update-profile');

    });
});

