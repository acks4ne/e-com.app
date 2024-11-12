<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::controller(ProductController::class)->group(function () {
        Route::get('/products', 'index')->name('products.index');
        Route::get('/products/{id}', 'show')
            ->name('products.show')
            ->where('id', '[0-9]+');
    });

    Route::controller(OrderController::class)->group(function () {
        Route::get('/orders', 'index')->name('orders.index')
            ->where('id', '[0-9]+');
        Route::get('/orders/{id}', 'show')->name('orders.show')
            ->where('id', '[0-9]+');
        Route::get('/orders/{id}', 'submit')->name('orders.submit')
            ->where('id', '[0-9]+');
    });

    Route::controller(CartController::class)->group(function () {
        Route::get('/cart', 'index')->name('carts.index');
        Route::post('/cart', 'addToCart')->name('carts.addToCart');
        Route::delete('/cart', 'removeFromCart')->name('carts.removeFromCart');
        Route::patch('/cart', 'updateInCart')->name('carts.updateInCart');
        Route::get('/cart/pay', 'pay')->name('carts.pay');
    });
});

Route::get('/payments/{user_id}/{order_id}', PaymentController::class)
    ->name('orders.pay')
    ->setWheres(['orderId' => '[0-9]+', 'userId' => '[0-9]+'])
    ->withoutMiddleware('auth:sanctum');

Route::controller(AuthController::class)->group(function () {
    Route::post('/register',
        [AuthController::class, 'register'])->withoutMiddleware(['auth:sanctum'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth:sanctum');
});


