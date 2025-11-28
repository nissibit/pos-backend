<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get("/api/banco/index", "APIController@getBancos")->name("api.banco.index");
Route::get("/api/payment/add", "APIController@AddPaymentItem")->name("api.payment.add");
Route::get("/api/entry/add", "APIController@AddEntry")->name("api.entry.add");
Route::get("/api/get-product", "APIController@getProduct")->name("api.get.product");
Route::get("/api/item/add", "APIController@Additems")->name("api.item.add");
Route::get("/api/exhange", "APIController@getLastExchange")->name("api.get.exchange");
Route::get("/api/product/statistic", "ProductController@getStatistic")->name("api.product.statistic");
Route::post("/api/product/specific/statistic", "ProductController@getSpecificStatistic")->name("api.product.specific.statistic");
Route::get("/api/items/customer", "ProductController@setCustomerDetails")->name("api.customer.details");
Route::get("/api/product/edit", "ProductController@editModal")->name("api.product.edit.modal");
Route::get("/api/product/update", "ProductController@updateModal")->name("api.product.update.modal");
Route::get("/api/product/get-flap", "ProductController@getFlap")->name("api.product.get-flap");
Route::get("/api/product/edit/price", "ProductController@editPriceModal")->name("api.product.price.edit.modal");
Route::get("/api/product/update/price", "ProductController@updatePriceModal")->name("api.product.price.update.modal");
