<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\AuthController;

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

// Protected Routes
Route::group(['middleware' => ['auth:sanctum']],function(){
    Route::patch('/products/{id}', [ProductController::class, 'show']);
    Route::delete('/products/{id}', [ProductController::class, 'show']);
    Route::post('/products', [ProductController::class, 'show']);
    // Route::resource('products', ProductController::class);
});
// Public Routes
Route::get('/products/search/{name}', [ProductController::class, 'search']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);

Route::group(['namespace' => 'Auth'], function(){
    Route::post('/register',[AuthController::class, 'register']);
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
