<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WisataController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('wisata')->group(function () {
    $controller = WisataController::class;
    Route::get('/', [$controller, 'index'] );
    Route::get('/{id}', [$controller, 'show'] );
    Route::post('/', [$controller, 'create'] );
    Route::put('/{id}', [$controller, 'update'] );
    Route::delete('/{id}', [$controller, 'delete'] );
});

