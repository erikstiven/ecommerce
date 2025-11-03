<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\FamilyController;
use App\Http\Controllers\Admin\OptionController;
use App\Http\Controllers\Admin\SubcategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CoverController;
use App\Http\Controllers\Admin\DriverController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ShipmentController;
use Database\Seeders\OptionSeeder;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

// =========================
// Dashboard con gráficas
// =========================
Route::get('/', function () {

    // Contar pedidos por estado (enum OrderStatus)
    $ordersByStatus = Order::select(DB::raw('status'), DB::raw('count(*) as total'))
        ->groupBy('status')
        ->get()
        ->mapWithKeys(function ($item) {
            // El campo status se castea al enum OrderStatus; usamos su nombre para mostrarlo
            return [$item->status->name => $item->total];
        });

    // Contar pedidos por mes del año actual
    $ordersByMonth = Order::select(DB::raw('MONTH(created_at) as month'), DB::raw('count(*) as total'))
        ->whereYear('created_at', date('Y'))
        ->groupBy(DB::raw('MONTH(created_at)'))
        ->orderBy(DB::raw('MONTH(created_at)'))
        ->pluck('total', 'month');

    return view('admin.dashboard', compact('ordersByStatus', 'ordersByMonth'));
})->middleware('can:access dashboard')
  ->name('dashboard');

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
