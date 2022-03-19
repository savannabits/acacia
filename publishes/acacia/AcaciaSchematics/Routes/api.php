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
        Route::get("acacia-schematics/dt", "Api\AcaciaSchematicController@dt")->name(
            "acacia-schematics.dt"
        );
        Route::apiResource("acacia-schematics", "Api\AcaciaSchematicController")->parameters(["acacia-schematics" => "schematic"]);
    });
