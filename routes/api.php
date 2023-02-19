<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('login', [App\Http\Controllers\Api\UserAuthController::class, 'login']);
Route::post('register', [App\Http\Controllers\Api\UserAuthController::class, 'register']);
 
Route::group(['middleware' => 'auth:api'], function(){
    // task route
    Route::get('allTask', [App\Http\Controllers\Api\taskController::class, 'allTask']);
    Route::get('getTask/{id}', [App\Http\Controllers\Api\taskController::class, 'getTask']);
    Route::post('addTask', [App\Http\Controllers\Api\taskController::class, 'addTask']);
    Route::post('updateTask/{id}', [App\Http\Controllers\Api\taskController::class, 'updateTask']);
    Route::get('removeTask/{id}', [App\Http\Controllers\Api\taskController::class, 'removeTask']);

    //logout
    Route::get('logout', [App\Http\Controllers\Api\UserAuthController::class, 'logout']);
});
Route::get('unauthorized', function () {
    return response()->json([
        'error' => 'Unauthorized.'
    ], 401);
})->name('unauthorized');