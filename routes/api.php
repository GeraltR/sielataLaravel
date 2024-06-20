<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;

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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware(['auth:sanctum'])->get('/pupils/{id}', [UsersController::class, 'pupils']);

Route::middleware(['auth:sanctum'])->post('/update_user/{id}', [UsersController::class, 'update']);
Route::middleware(['auth:sanctum'])->post('/change_teacher/{id}', [UsersController::class, 'change_teacher']);
Route::middleware(['auth:sanctum'])->post('/add_pupil/{id}', [UsersController::class, 'add_pupil']);
