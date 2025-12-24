<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\FamilyController;
use App\Http\Controllers\Admin\OptionController;
use App\Http\Controllers\Admin\SubcategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CoverController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DriverController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ShipmentController;
use Database\Seeders\OptionSeeder;

Route::get('/', [DashboardController::class, 'index'])
    ->name('dashboard');
Route::get('/estadisticas', [DashboardController::class, 'statistics'])
    ->name('estadisticas');

// =========================
// Resto de recursos admin
// =========================

Route::get('/options', [OptionController::class, 'index'])->name('options.index');

Route::resource('families', FamilyController::class);
Route::resource('categories', CategoryController::class);
Route::resource('subcategories', SubcategoryController::class);
Route::resource('products', ProductController::class);
Route::get('products/{product}/variants/{variant}', [ProductController::class, 'variants'])
    ->name('products.variants')
    ->scopeBindings();

Route::put('products/{product}/variants/{variant}', [ProductController::class, 'variantsUpdate'])
    ->name('products.variantsUpdate')
    ->scopeBindings();

Route::resource('covers', CoverController::class);
Route::resource('drivers', DriverController::class);

Route::get('shipments', [ShipmentController::class, 'index'])->name('shipments.index');
Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
