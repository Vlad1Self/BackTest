<?php

use Illuminate\Support\Facades\Route;

Route::prefix('products')->group(function () {
    Route::get('/{page}', [App\Http\Controllers\Product\ProductController::class, 'indexProduct']);
});
