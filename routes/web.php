<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\CategoryController;
use \App\Http\Controllers\BrandController;
use \App\Http\Controllers\UnitController;
use \App\Http\Controllers\ProductController;
use \App\Http\Controllers\ProductSupplierController;
use \App\Http\Controllers\SupplierController;
use \App\Http\Controllers\PurchaseController;
use \App\Http\Controllers\PurchaseItemController;
use \App\Http\Controllers\PurchasePaymentController;
use \App\Http\Controllers\PurchaseReturnController;
use \App\Http\Controllers\PurchaseReturnItemController;
use \App\Http\Controllers\CustomerController;

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
    Route::resource('product-suppliers', ProductSupplierController::class)
        ->except('show');
    Route::resource('suppliers', SupplierController::class)
        ->except('show');
    Route::resource('purchases', PurchaseController::class)
        ->except('show');
    Route::resource('purchase-items', PurchaseItemController::class)
        ->except('show');
    Route::resource('purchase-payments', PurchasePaymentController::class)
        ->except('show');
    Route::resource('purchase-returns', PurchaseReturnController::class)
        ->except('show');
    Route::resource('purchase-return-items', PurchaseReturnItemController::class)
        ->except('show');
    Route::resource('customers', CustomerController::class)
        ->except('show');
});

require __DIR__.'/settings.php';
