<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\BookController;
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


Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/category', [CategoriesController::class, 'create']);
    Route::get('/allcategories', [CategoriesController::class, 'getAll']);
    Route::get('/delete', [CategoriesController::class, 'delete']);
    Route::get('/roadmap', [\App\Http\Controllers\RoadMapController::class, 'getByBook']);
});

Route::group(['middleware' => 'auth:sanctum', 'prefix'=>'users'], function () {
    Route::get('/aworks', [UsersController::class, 'getAuthorWorks']);
    Route::get('/rworks', [UsersController::class, 'getRedactorWorks']);
    Route::get('/lworks', [UsersController::class, 'getIllustratorWorks']);
    Route::get('/all', [UsersController::class, 'getAllUsers']);
    Route::get('/deleta', [UsersController::class, 'delete']);
    Route::get('/deleter', [UsersController::class, 'deleteRedactor']);
    Route::get('/deletei', [UsersController::class, 'deleteIllustrator']);

});


Route::group(['middleware' => 'auth:sanctum', 'prefix' => 'book'], function () {
    Route::post('/create', [BookController::class, 'create']);
    Route::get('/all', [BookController::class, 'getAll']);
    Route::post('/name', [BookController::class, 'updateName']);
    Route::post('/content', [BookController::class, 'updateContent']);
    Route::post('/illustrator', [BookController::class, 'changeIllustrator']);
    Route::post('/redactor', [BookController::class, 'changeRedactor']);
    Route::post('/delete', [BookController::class, 'delete']);
    Route::get('/author', [BookController::class, 'getByUser']);
    Route::get('/get', [BookController::class, 'getById']);

});


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
