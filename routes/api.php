<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\RegisteredModelsController;
use App\Http\Controllers\ModelsRatingsController;

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
Route::middleware(['auth:sanctum'])->get('/learners/{id}', [UsersController::class, 'get_learners']);
Route::middleware(['auth:sanctum'])->get('/categories/{rok}', [CategoriesController::class, 'get_categories']);
Route::middleware(['auth:sanctum'])->get('/models/{id}', [RegisteredModelsController::class, 'get_models']);
Route::middleware(['auth:sanctum'])->get('/printmodels/{id}', [RegisteredModelsController::class, 'print_models']);
Route::middleware(['auth:sanctum'])->get('/listModels/classfilter/{idclass}/category/{id}/age/{age}/name/{name}', [RegisteredModelsController::class, 'get_listModels']);
Route::middleware(['auth:sanctum'])->get('/list2points/{category}/{userid}', [RegisteredModelsController::class, 'get_list2points']);

Route::middleware(['auth:sanctum'])->post('/update_user/{id}', [UsersController::class, 'update']);
Route::middleware(['auth:sanctum'])->post('/change_teacher/{id}', [UsersController::class, 'change_teacher']);
Route::middleware(['auth:sanctum'])->post('/add_learner/{id}', [UsersController::class, 'add_learner']);
Route::middleware(['auth:sanctum'])->post('/update_learner/{id}', [UsersController::class, 'update_learner']);
Route::middleware(['auth:sanctum'])->post('/add_model', [RegisteredModelsController::class, 'store']);
Route::middleware(['auth:sanctum'])->post('/update_model/{id}', [RegisteredModelsController::class, 'update_model']);
Route::middleware(['auth:sanctum'])->post('/set_points/{id}/{user_id}', [ModelsRatingsController::class, 'set_points']);


Route::middleware(['auth:sanctum'])->delete('/delete_learner/{id}', [UsersController::class, 'delete_learner']);
Route::middleware(['auth:sanctum'])->delete('/delete_model/{id}', [RegisteredModelsController::class, 'delete_model']);
