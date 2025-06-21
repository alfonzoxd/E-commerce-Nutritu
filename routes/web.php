<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CheckoutController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/secciones/{categoria?}', [HomeController::class, 'secciones'])
     ->where('categoria', '[a-z]+')
     ->name('secciones');
Route::get('/producto/{id}', [HomeController::class, 'detalle'])
     ->where('id', '[0-9]+')
     ->name('producto.detalle');

Route::get('/carrito', [HomeController::class, 'carrito'])->name('carrito');
Route::post('/carrito/agregar/{id}', [HomeController::class, 'agregarCarrito'])
     ->where('id', '[0-9]+')
     ->name('carrito.agregar');
Route::delete('/carrito/eliminar/{id}', [HomeController::class, 'eliminarDelCarrito'])->name('carrito.eliminar');
Route::post('/carrito/limpiar', [HomeController::class, 'limpiarCarrito'])->name('carrito.limpiar');
Route::get('/contactanos', [HomeController::class, 'contactanos'])->name('contactanos');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');

