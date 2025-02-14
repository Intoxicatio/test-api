<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('check_auth_token')->get('/orders', 'App\Http\Controllers\Api\OrderController@index');
Route::middleware('check_auth_token')->get('/incomes','App\Http\Controllers\Api\IncomeController@index');
Route::middleware('check_auth_token')->get('/sales','App\Http\Controllers\Api\SaleController@index');
Route::middleware('check_auth_token')->get('/stocks','App\Http\Controllers\Api\StockController@index');
