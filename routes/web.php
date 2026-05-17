<?php

use App\Http\Controllers\Admin\CategoriaController;
use App\Http\Controllers\Admin\ComercioController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InventarioController;
use App\Http\Controllers\Admin\PedidoController;
use App\Http\Controllers\Admin\ProductoController;
use App\Http\Controllers\Admin\ReporteController;
use App\Http\Controllers\Admin\UsuarioController;
use Illuminate\Support\Facades\Route;

// ── Raíz ──────────────────────────────────────────────────────────────────────
Route::get('/', function () {
    if (auth()->check()) {
        return match (auth()->user()->role) {
            \App\Enums\Role::Admin       => redirect()->route('admin.dashboard'),
            \App\Enums\Role::Comerciante => redirect()->route('comercio.dashboard'),
            \App\Enums\Role::Comprador   => redirect()->route('tienda.index'),
            \App\Enums\Role::Repartidor  => redirect()->route('repartidor.dashboard'),
        };
    }
    return redirect()->route('login');
});

// ── Admin ──────────────────────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('categorias', CategoriaController::class);

    Route::resource('comercios', ComercioController::class);
    Route::post('comercios/{comercio}/toggle', [ComercioController::class, 'toggleActivo'])->name('comercios.toggle');

    Route::resource('productos', ProductoController::class);

    Route::resource('usuarios', UsuarioController::class);

    Route::get('pedidos', [PedidoController::class, 'index'])->name('pedidos.index');
    Route::get('pedidos/{pedido}', [PedidoController::class, 'show'])->name('pedidos.show');
    Route::put('pedidos/{pedido}/estado', [PedidoController::class, 'updateEstado'])->name('pedidos.estado');

    Route::get('inventario', [InventarioController::class, 'index'])->name('inventario.index');
    Route::post('inventario/{producto}/movimiento', [InventarioController::class, 'movimiento'])->name('inventario.movimiento');
    Route::get('inventario/{producto}/historial', [InventarioController::class, 'historial'])->name('inventario.historial');

    Route::get('reportes', [ReporteController::class, 'index'])->name('reportes.index');
    Route::get('reportes/exportar', [ReporteController::class, 'exportarCSV'])->name('reportes.exportar');
});

// ── Comerciante ────────────────────────────────────────────────────────────────
Route::prefix('comercio')->name('comercio.')->middleware(['auth', 'role:comerciante'])->group(function () {
    Route::get('/dashboard', function () { return view('comercio.dashboard'); })->name('dashboard');
});

// ── Comprador ──────────────────────────────────────────────────────────────────
Route::prefix('tienda')->name('tienda.')->middleware(['auth', 'role:comprador'])->group(function () {
    Route::get('/', function () { return view('tienda.index'); })->name('index');
});

// ── Repartidor ─────────────────────────────────────────────────────────────────
Route::prefix('repartidor')->name('repartidor.')->middleware(['auth', 'role:repartidor'])->group(function () {
    Route::get('/dashboard', function () { return view('repartidor.dashboard'); })->name('dashboard');
});

require __DIR__.'/auth.php';
