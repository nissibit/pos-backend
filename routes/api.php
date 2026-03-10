<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\ProductController;
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



Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/profile', [AuthController::class, 'profile']);

    // User management routes - only accessible by admin users
    Route::apiResource('/users', UserController::class)->middleware('role:admin');

    Route::get('/user', function (Request $request) {
        return $request->user();
    });


    Route::name('api.')->group(function () {
        Route::apiResource('products', ProductController::class);
        Route::get("/products/fetch/{q?}", [ProductController::class, 'fetch'])->name("products.fetch");

        // Facturas
        Route::apiResource('facturas', FacturaController::class);
        Route::get('facturas/{payed}', [FacturaController::class, 'list'])
        ->where('payed', '[0-1]') // Só aceita 0 ou 1
        ->name('facturas.list');
    });
});
