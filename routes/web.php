<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CarreraController;
use App\Http\Controllers\TipoController;
use App\Http\Controllers\InvestigadorController;
use App\Http\Controllers\ProductividadController;
use App\Http\Controllers\AsignarInvestigadorController;
use App\Http\Controllers\ReporteController;
Route::get('/', function () {
    return redirect()->route('carreras.index');
});

Route::resource('carreras', CarreraController::class);

Route::resource('tipos', TipoController::class);

Route::resource('investigadores', InvestigadorController::class);

Route::resource('productividades', ProductividadController::class);

Route::resource( 'asignarinvestigadores', AsignarInvestigadorController::class);
Route::get( '/reportes', [ReporteController::class, 'index'])->name('reportes.index');