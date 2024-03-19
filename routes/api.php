<?php

use App\Http\Controllers\API\Auth\RegisteredCustomerController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\CustomerController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/auth', RegisteredCustomerController::class)->middleware('web');

Route::get('/products', ProductController::class);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::patch('/customer/payment', [CustomerController::class, 'payment']);

    Route::post('/cart/add', [CartController::class, 'addToCart']);
    Route::delete('/cart/remove', [CartController::class, 'removeFromCart']);

    Route::post('/orders/create', [OrderController::class, 'create']);
    Route::post('/orders/{order:uuid}/complete', [OrderController::class, 'complete']);
    Route::post('/orders/{order:uuid}/cancel', [OrderController::class, 'cancel']);
});



