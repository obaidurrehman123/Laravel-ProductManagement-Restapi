<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// product routes

Route::get('/products', [ProductController::class, 'getAllProduct']);
Route::group(['middleware' => 'auth:api'], function () {
    Route::post('/addProduct',[ProductController::class,'addingProduct']);
    Route::delete('/deleteProduct/{id}', [ProductController::class, 'deleteProduct']);
});

// user routes

Route::post('/createUser',[UsersController::class,'signUp']);
Route::post('/singinUser',[UsersController::class,'signIn']);