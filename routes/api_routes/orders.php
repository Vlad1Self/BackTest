<?php

use Illuminate\Support\Facades\Route;

Route::prefix('orders')->group(function() {
    Route::get('/index/{userId}/{page}', [App\Http\Controllers\Order\OrderController::class, 'index']);
    Route::post('/', [App\Http\Controllers\Order\OrderController::class, 'store']);
    Route::delete('/delete/{uuid}', [App\Http\Controllers\Order\OrderController::class, 'delete']);

    Route::get('/total-sum/{userId}', [App\Http\Controllers\Order\OrderController::class, 'getTotalOrderSumByUserId']);
});
