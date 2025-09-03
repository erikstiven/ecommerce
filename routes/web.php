<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Admin\FamilyController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\FamilyController as ControllersFamilyController;
use App\Http\Controllers\ProductController as ControllersProductController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Models\Variant;

Route::get('/', [WelcomeController::class, 'index'])->name('welcome.index');

Route::get('families/{family}', [ControllersFamilyController::class, 'show'])->name('families.show');
Route::get('categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('subcategories/{subcategory}', [SubcategoryController::class, 'show'])->name('subcategories.show');
Route::get('products/{product}', [ControllersProductController::class, 'show'])->name('products.show');

Route::get('cart', [CartController::class, 'index'])->name('cart.index');

// Shipping routes
Route::get('shipping', [ShippingController::class, 'index'])->name('shipping.index');

// Checkout completo protegido por login
Route::middleware('auth')->group(function () {
    // Página de checkout
    Route::get('checkout', [CheckoutController::class, 'checkout'])->name('checkout.index');

    // PayPhone: inicio del pago
    Route::post('checkout/payphone/start', [CheckoutController::class, 'startPayphone'])->name('checkout.payphone.start');

    // Confirmación posterior al pago (desde tu app)
    Route::get('/payphone/respuesta', [CheckoutController::class, 'respuesta'])->name('payphone.respuesta');

    // Depósito bancario
    Route::post('checkout/deposit', [CheckoutController::class, 'deposit'])->name('checkout.deposit');

    // Pantallas finales
    Route::get('checkout/paid', [CheckoutController::class, 'paid'])->name('checkout.paid');
    Route::get('checkout/thanks', [CheckoutController::class, 'thanks'])->name('checkout.thanks');
});

// Jetstream Dashboard protegido
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
