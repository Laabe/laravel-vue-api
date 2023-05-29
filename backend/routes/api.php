<?php

use App\Http\Controllers\Api\GroupController;
use App\Http\Controllers\Api\UserController;
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

// Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('groups/{group}/attach-user/{user}', [GroupController::class, 'attach']);
Route::post('groups/{group}/detach-user/{user}', [GroupController::class, 'detach']);
Route::apiResource('groups', GroupController::class);

Route::post('users/{user}/attach-group/{group}', [UserController::class, 'attach']);
Route::post('users/{user}/detach-group/{group}', [UserController::class, 'detach']);
Route::apiResource('users', UserController::class);
