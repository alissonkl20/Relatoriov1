<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::resource('dashboard', DashboardController::class)->except('show');

Route::resource('categorias', CategoriaController::class)
    ->except('show')
    ->parameters(['categorias' => 'categoria']);

// PÁGINA INICIAL
Route::get('/', function () {
    return redirect()->route('dashboard.index');
});
