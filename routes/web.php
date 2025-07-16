<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Admin\FamilyController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\FamilyController as ControllersFamilyController;
use App\Http\Controllers\ProductController as ControllersProductController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Models\Variant;

Route::get('/', [WelcomeController::class, 'index'])->name('welcome.index');

Route::get('families/{family}' , [ControllersFamilyController::class, 'show'])->name('families.show');

Route::get('categories/{category}' , [CategoryController::class, 'show'])->name('categories.show');

Route::get('subcategories/{subcategory}' , [SubcategoryController::class, 'show'])->name('subcategories.show');

Route::get('products/{product}',[ControllersProductController ::class, 'show'])->name('products.show');

Route::get('cart',[CartController::class, 'index'])->name('cart.index');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});



