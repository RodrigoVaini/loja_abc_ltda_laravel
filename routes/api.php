<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ProductController;

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

Route::get('products', [ProductController::class, 'getAll']);
Route::get('products/{id}', [ProductController::class, 'getItem']);
Route::post('products/create', [ProductController::class, 'create']);
Route::put('products/{id}', [ProductController::class, 'edit']);
Route::delete('products/{id}', [ProductController::class, 'delete']);

Route::get('sales', [SaleController::class, 'getAll']);
Route::get('sales/{id}', [SaleController::class, 'getById']);
Route::get('sales/date/{date}', [SaleController::class, 'getSalesByDate']);
Route::post('sales', [SaleController::class, 'create']);
Route::delete('sales/{id}', [SaleController::class, 'delete']);
Route::post('/sales/{id}/items', [SaleController::class, 'addItem']);

/*Route::get('/sales', [SaleController::class, 'index']);
Route::get('/sales/create', [SaleController::class, 'create']);
Route::get('/sales/{id}', [SaleController::class, 'show']);
Route::get('/sales/{id}/edit', [SaleController::class, 'edit']);
Route::put('/sales/{id}', [SaleController::class, 'update']);

Route::get('/items/{id}/edit', [SaleController::class, 'editItem']);
Route::put('/items/{id}', [SaleController::class, 'updateItem']);
Route::delete('/items/{id}', [SaleController::class, 'destroyItem']);*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
