<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoriaController;

// DESPESAS
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard.index');

Route::get('/dashboard/create', [DashboardController::class, 'create'])
    ->name('dashboard.create');

Route::post('/dashboard', [DashboardController::class, 'postDashboard'])
    ->name('dashboard.store');

Route::get('/dashboard/{id}/edit', [DashboardController::class, 'edit'])
    ->name('dashboard.edit');

Route::put('/dashboard/{id}', [DashboardController::class, 'putDashboard'])
    ->name('dashboard.update');

Route::delete('/dashboard/{id}', [DashboardController::class, 'deleteDashboard'])
    ->name('dashboard.destroy');

// CATEGORIAS
Route::get('/categorias', [CategoriaController::class, 'index'])
    ->name('categorias.index');

Route::get('/categorias/create', [CategoriaController::class, 'create'])
    ->name('categorias.create');

Route::post('/categorias', [CategoriaController::class, 'store'])
    ->name('categorias.store');

Route::get('/categorias/{id}/edit', [CategoriaController::class, 'edit'])
    ->name('categorias.edit');

Route::put('/categorias/{id}', [CategoriaController::class, 'update'])
    ->name('categorias.update');

Route::delete('/categorias/{id}', [CategoriaController::class, 'destroy'])
    ->name('categorias.destroy');

// PÁGINA INICIAL
Route::get('/', function () {
    return redirect()->route('dashboard.index');
});
