<?php

use Illuminate\Support\Facades\Route;

Route::prefix('orders')->group(function() {
    Route::get('/{userId}/{page}', [App\Http\Controllers\Order\OrderController::class, 'index']);
    Route::get('/show/{id}', [App\Http\Controllers\Order\OrderController::class, 'show']);
    Route::post('/', [App\Http\Controllers\Order\OrderController::class, 'store']);
    Route::delete('/delete/{uuid}', [App\Http\Controllers\Order\OrderController::class, 'delete']);
});
