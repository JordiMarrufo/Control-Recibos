<?php

use App\Http\Controllers\PagoMensual_Controller;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Welcome')->name('home');
Route::inertia('/registroinquilinos', 'inquilinos/Dash_inquilinos')->name('RegistroInquilinos');
Route::inertia('/controlpagos', 'ControlPagos')->name('ControlPagos');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
});

//Rutas de Inquilino
Route::resource('inquilinosback', \App\Http\Controllers\Inquilino_Controller::class);

//Rutas de Pago Mensual
Route::resource('pagoMensualinquilino', PagoMensual_Controller::class);

require __DIR__ . '/settings.php';
