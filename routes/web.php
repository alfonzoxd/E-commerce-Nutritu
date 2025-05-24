<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

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
Route::get('/contactanos', [HomeController::class, 'contactanos'])->name('contactanos');
