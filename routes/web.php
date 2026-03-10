<?php

use App\Http\Controllers\FacturaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/facturas', [FacturaController::class, 'index'])->name('facturas.index');
Route::get('/facturas/create', [FacturaController::class, 'create'])->name('facturas.create');
Route::get('/facturas/display/{factura}', [FacturaController::class, 'display'])->name('facturas.display');
Route::get('/facturas/{payed}/{q?}', [FacturaController::class, 'list'])->name('facturas.list');
Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
Route::get('/payments/create', [PaymentController::class, 'create'])->name('payments.create');
Route::get('/products', [PaymentController::class, 'index'])->name('products.index');

