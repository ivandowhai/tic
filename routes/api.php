<?php

use App\Http\Controllers\GameController;
use Illuminate\ {
  Http\Request,
  Support\Facades\Route
};

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

Route::group(['prefix' => 'v1/'], function () {
    Route::group(['prefix' => 'game'], function () {
        Route::get('/', [GameController::class, 'index']);
        Route::post('/', [GameController::class, 'create']);
        Route::get('/{game}', [GameController::class, 'show']);
        Route::put('/{game}', [GameController::class, 'move']);
        Route::delete('/{game}', [GameController::class, 'delete']);
    });
});
