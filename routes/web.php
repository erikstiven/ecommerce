<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AboutController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Admin\FamilyController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\FamilyController as ControllersFamilyController;
use App\Http\Controllers\LegalController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ProductController as ControllersProductController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\WelcomeController;

use App\Models\Product;
use App\Models\Variant;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;

/*
|--------------------------------------------------------------------------
| Rutas web
|--------------------------------------------------------------------------
| TEMPORAL: mientras no hay BD, la home devuelve una vista estática
| (no consulta base de datos).
*/
Route::get('/', function () {
    return response('<!doctype html><meta charset="utf-8"><title>OK</title><h1>Laravel en Hostinger ✔️</h1><p>Sin BD y sin Vite (temporal).</p>', 200);
})->name('welcome.index');


// Cuando conectes la BD, vuelve a esta línea:
// Route::get('/', [WelcomeController::class, 'index'])->name('welcome.index');
//ultimo verificar
Route::get('families/{family}', [ControllersFamilyController::class, 'show'])->name('families.show');
Route::get('categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('subcategories/{subcategory}', [SubcategoryController::class, 'show'])->name('subcategories.show');
Route::get('products/{product}', [ControllersProductController::class, 'show'])->name('products.show');

Route::get('cart', [CartController::class, 'index'])->name('cart.index');

// Nosotros
Route::get('/sobre-nosotros', [AboutController::class, 'index'])->name('sobre-nosotros');
// Servicios
Route::get('/servicios', [ServicesController::class, 'index'])->name('servicios');
// Ubicación
Route::get('/ubicacion', [LocationController::class, 'index'])->name('ubicacion');

// Legal
Route::get('/legal', [LegalController::class, 'index'])->name('legal');

// Envíos
Route::get('shipping', [ShippingController::class, 'index'])
    ->middleware(['auth']) // <-- requiere login
    ->name('shipping.index');

Route::post('shipping', [ShippingController::class, 'store'])
    ->name('shipping.store'); // <-- nueva

// Checkout (requiere login)
Route::middleware('auth')->group(function () {

    // Página principal de checkout
    Route::get('checkout', [CheckoutController::class, 'checkout'])->name('checkout.index');

    // Iniciar pago con PayPhone (crea orden y devuelve $pp y $order)
    Route::post('checkout/payphone/start', [CheckoutController::class, 'startPayphone'])
        ->name('checkout.payphone.start');

    // Retorno/confirmación desde PayPhone (redirige al usuario con query params)
    Route::get('payphone/respuesta', [CheckoutController::class, 'respuesta'])
        ->name('payphone.respuesta');

    // Depósito bancario (subida de comprobante)
    Route::post('checkout/deposit', [CheckoutController::class, 'deposit'])
        ->name('checkout.deposit');

    // Pantallas finales
    Route::get('checkout/paid', [CheckoutController::class, 'paid'])->name('checkout.paid');
    Route::get('checkout/thanks', [CheckoutController::class, 'thanks'])->name('checkout.thanks');
});

// Jetstream Dashboard (requiere login + verificación)
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// Ruta de prueba (usa BD; no la abras si aún no configuras la base)
Route::get('prueba', function () {
    $order = Order::first();
    $pdf = Pdf::loadView('orders.ticket', compact('order'))->setPaper('a4','landscape');

    $pdf->save(storage_path('app/public/tickets/ticket-' . $order->id . '.pdf'));

    $order->pdf_path = 'tickets/ticket-' . $order->id . '.pdf';
    $order->save();

    return "Ticket generado correctamente";
    // return view('orders.ticket', compact('order'));
});
