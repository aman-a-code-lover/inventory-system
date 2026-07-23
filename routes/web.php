<?php

use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');

    Route::resource('categories', \App\Http\Controllers\CategoryController::class)
        ->except(['show']);
    Route::resource('brands', \App\Http\Controllers\BrandController::class)
        ->except(['show']);
});

require __DIR__.'/settings.php';
