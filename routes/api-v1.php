<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\CategoryController;

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

Route::post('register', [RegisterController::class, 'store'])->name('api.v1.register');

/* Route::get('categories', [CategoryController::class, 'index'])->name('api.v1.categories.index');
Route::post('categories', [CategoryController::class, 'store'])->name('api.v1.categories.store');
Route::get('categories/{category}', [CategoryController::class, 'show'])->name('api.v1.categories.show');
Route::put('categories/{category}', [CategoryController::class, 'update'])->name('api.v1.categories.update');
Route::delete('categories/{category}', [CategoryController::class, 'delete'])->name('api.v1.categories.delete'); */

Route::apiResource('categories', CategoryController::class)->names('api.v1.categories');
