<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\DevProjectController;
use App\Http\Controllers\api\PostController;
use App\Http\Controllers\api\UserController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('listDevProject', [DevProjectController::class, 'listDevProject']);
Route::get('listUser', [UserController::class, 'listUser']);
Route::get('listPost', [PostController::class, 'listPost']);
Route::get('serviceList',[PostController::class, 'serviceList']);