<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\CategoryController;
use \App\Http\Controllers\BrandController;
use \App\Http\Controllers\UnitController;
use \App\Http\Controllers\ProductController;

Route::inertia('/', 'Welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');

    Route::resource('categories', CategoryController::class)
        ->except(['show']);
    Route::resource('brands', BrandController::class)
        ->except(['show']);
    Route::resource('units', UnitController::class)
        ->except('show');
    Route::resource('products', ProductController::class)
        ->except('show');
});

require __DIR__.'/settings.php';
