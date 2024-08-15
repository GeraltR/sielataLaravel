<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\RegisteredModelsController;
use App\Http\Controllers\ModelsRatingsController;
use App\Http\Controllers\GrandPrixesController;
use App\Http\Controllers\GrandsControler;

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
Route::middleware(['auth:sanctum'])->get('/listModels/classfilter/{idclass}/category/{id}/age/{age}/name/{name}', [RegisteredModelsController::class, 'get_list_models']);
Route::middleware(['auth:sanctum'])->get('/list2points/{category}/{userid}', [RegisteredModelsController::class, 'get_list2points']);
Route::middleware(['auth:sanctum'])->get('/twocategories/{categorya}/{categoryb}', [RegisteredModelsController::class, 'get_twocategories']);
Route::middleware(['auth:sanctum'])->get('/ratingmodels/{category}', [RegisteredModelsController::class, 'get_models_in_category']);
Route::middleware(['auth:sanctum'])->get('/statistics', [RegisteredModelsController::class, 'get_statistics']);
Route::middleware(['auth:sanctum'])->get('/listgrandprixes/{isactiv}', [GrandPrixesController::class, 'get_list_grand_prixes']);
Route::middleware(['auth:sanctum'])->get('/resultgrandprixes', [GrandsControler::class, 'get_list']);

Route::middleware(['auth:sanctum'])->post('/update_user/{id}', [UsersController::class, 'update']);
Route::middleware(['auth:sanctum'])->post('/change_teacher/{id}', [UsersController::class, 'change_teacher']);
Route::middleware(['auth:sanctum'])->post('/add_learner/{id}', [UsersController::class, 'add_learner']);
Route::middleware(['auth:sanctum'])->post('/update_learner/{id}', [UsersController::class, 'update_learner']);
Route::middleware(['auth:sanctum'])->post('/add_model', [RegisteredModelsController::class, 'store']);
Route::middleware(['auth:sanctum'])->post('/update_model/{id}', [RegisteredModelsController::class, 'update_model']);
Route::middleware(['auth:sanctum'])->post('/saverating', [RegisteredModelsController::class, 'save_rating']);
Route::middleware(['auth:sanctum'])->post('/connectcategories/{categorya}/{categoryb}', [RegisteredModelsController::class, 'connect_category']);
Route::middleware(['auth:sanctum'])->post('/set_points/{user_id}', [ModelsRatingsController::class, 'set_points']);
Route::middleware(['auth:sanctum'])->post('/add_grand', [GrandsControler::class, 'store']);


Route::middleware(['auth:sanctum'])->delete('/delete_learner/{id}', [UsersController::class, 'delete_learner']);
Route::middleware(['auth:sanctum'])->delete('/delete_model/{id}', [RegisteredModelsController::class, 'delete_model']);
Route::middleware(['auth:sanctum'])->delete('/delete_result_grand_prix/{id}', [GrandsControler::class, 'delete_result_grand_prix']);
