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
use App\Http\Controllers\SearchController;


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
/*Route::get('/', function () {
    $html = <<<'HTML'
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Próxima apertura | HMBSport</title>
  <style>
    :root{
      --bg1:#0f1020; --bg2:#1d1140; --acc:#7c3aed; --acc2:#22d3ee; --txt:#e5e7eb;
    }
    *{box-sizing:border-box}
    html,body{height:100%}
    body{
      margin:0; font-family: ui-sans-serif,system-ui,-apple-system,Segoe UI,Roboto,Inter,Arial;
      color:var(--txt);
      background: radial-gradient(1200px 600px at 20% -10%, #1a1a3a 10%, transparent 60%) no-repeat,
                  radial-gradient(1000px 600px at 120% 120%, #0a3a4a 5%, transparent 60%) no-repeat,
                  linear-gradient(135deg, var(--bg1), var(--bg2));
      display:grid; place-items:center; padding:24px;
    }
    .card{
      width:min(880px, 96vw);
      background:rgba(255,255,255,.04);
      border:1px solid rgba(255,255,255,.08);
      border-radius:24px; padding:36px;
      box-shadow: 0 10px 40px rgba(0,0,0,.35), inset 0 1px 0 rgba(255,255,255,.04);
      backdrop-filter: blur(6px);
    }
    .badge{
      display:inline-flex; gap:8px; align-items:center;
      padding:6px 12px; border-radius:999px; font-size:12px; letter-spacing:.3px;
      background:linear-gradient(90deg, rgba(124,58,237,.25), rgba(34,211,238,.25));
      border:1px solid rgba(124,58,237,.35);
    }
    .title{font-size:clamp(32px,4.5vw,54px); margin:14px 0 8px; line-height:1.05; font-weight:800}
    .grad{
      background: linear-gradient(90deg, var(--acc), var(--acc2));
      -webkit-background-clip:text; background-clip:text; color:transparent;
    }
    .desc{opacity:.9; font-size:clamp(16px,2.2vw,18px); margin:0 0 20px}
    .row{display:flex; flex-wrap:wrap; gap:14px; margin:18px 0 6px}
    .pill{
      padding:10px 14px; border-radius:12px; background:rgba(255,255,255,.06);
      border:1px solid rgba(255,255,255,.1); font-size:14px
    }
    .cta{
      display:inline-block; padding:14px 18px; border-radius:14px; margin-top:16px;
      font-weight:600; text-decoration:none; color:#0b1020;
      background:linear-gradient(90deg, var(--acc), var(--acc2));
      box-shadow:0 10px 24px rgba(124,58,237,.35);
      transition: transform .12s ease, box-shadow .12s ease;
    }
    .cta:hover{transform:translateY(-1px); box-shadow:0 16px 30px rgba(124,58,237,.45)}
    .footer{opacity:.7; font-size:12px; margin-top:22px}
    .grid{display:grid; grid-template-columns: 1fr; gap:18px}
    .panel{padding:14px 16px; border-radius:14px; background:rgba(0,0,0,.25); border:1px solid rgba(255,255,255,.06)}
    .kpi{font: 800 24px/1.1 ui-sans-serif,system-ui; margin:0}
    .kcap{opacity:.8; font-size:12px; margin-top:6px}
    @media (min-width:720px){ .grid{grid-template-columns: 2.2fr 1fr} }
  </style>
</head>
<body>
  <main class="card">
    <span class="badge">🚧 Próxima apertura</span>
    <h1 class="title">HMBSport <span class="grad">muy pronto</span></h1>
    <p class="desc">Estamos preparando algo genial. La tienda se abrirá en breve. Gracias por tu paciencia 🙌</p>

    <div class="grid">
      <section class="panel">
        <p class="kpi">🛍️ Catálogo en construcción</p>
        <p class="kcap">Trabajamos en rendimiento, seguridad y medios de pago.</p>
        <div class="row">
          <span class="pill">⚡ Rápido</span>
          <span class="pill">🔒 Seguro</span>
          <span class="pill">📦 Envíos a todo el país</span>
        </div>
        <a class="cta" href="mailto:contacto@codecima.com?subject=Avisarme%20cuando%20abran">Quiero que me avisen</a>
      </section>

      <aside class="panel">
        <p class="kpi">⏳ 90% listo</p>
        <p class="kcap">Últimos detalles de despliegue.</p>
        <p class="kcap">Soporte: <a href="mailto:contacto@codecima.com" style="color:#a5b4fc;text-decoration:none">contacto@codecima.com</a></p>
      </aside>
    </div>

    <p class="footer">© <span id="y"></span> HMBSport · Todos los derechos reservados</p>
  </main>
  <script>document.getElementById('y').textContent = new Date().getFullYear()</script>
</body>
</html>
HTML;
    return response($html, 200)->header('Content-Type', 'text/html; charset=utf-8');
});*/
Route::get('/', [WelcomeController::class, 'index'])->name('welcome.index');

Route::get('/buscar', [SearchController::class, '__invoke'])->name('search');



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
