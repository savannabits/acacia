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
        Route::post(
            "roles/{role}/assign-permission",
            "Api\RoleController@assignPermission"
        )->name("roles.role.assign-permission");
        Route::get("roles/dt", "Api\RoleController@dt")->name("roles.dt");
        Route::apiResource("roles", "Api\RoleController");
    });
