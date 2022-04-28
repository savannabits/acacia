<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix("v1")
    ->middleware(["auth:sanctum"])
    ->as("api.v1.")
    ->group(function () {
        Route::match(['put','post'],'users/{user}/role',[\Acacia\Users\Http\Controllers\Api\UserController::class,'toggleRole'])->name('users.user.toggle-role');
        Route::get("users/dt", "Api\UserController@dt")->name("users.dt");
        Route::apiResource("users", "Api\UserController");
    });
