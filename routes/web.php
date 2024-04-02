<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', [ProductController::class, 'show']);

Route::post('/', [ProductController::class, 'store'])->name('createProduct');
