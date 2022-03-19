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

use Illuminate\Support\Facades\Route;

Route::prefix(config('acacia.route_prefix','acacia'))
    ->middleware(['auth:sanctum'])
    ->as("acacia.")
    ->group(function() {
        Route::get('/', 'AcaciaController@index')->name('backend.index');
        Route::prefix('/g-panel')->as('g-panel.')->group(function (){
            Route::get('', [\Acacia\Core\Http\Controllers\GPanelController::class,'index'])->name('index');
//            Route::resource('schematics',"AcaciaSchematicController");
        });
        Route::resource("acacia-menu","AcaciaMenuController");
    });
