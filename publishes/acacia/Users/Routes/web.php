<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix(config("acacia.route_prefix", "acacia"))
    ->middleware(["auth:sanctum"])
    ->as("acacia.auth.")
    ->group(function () {
        Route::resource("users", "UserController");
    });
