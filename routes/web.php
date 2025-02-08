<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\BackupsController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\PedidosController;

use App\Models\Categories;
// Rutas no autenticadas
Route::get('/', [DashboardController::class, 'index']);
Route::permanentRedirect('/register', '/');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Rutas auntenticadas
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::resource('/role', RoleController::class);
    Route::resource('/categories', CategoryController::class);
    Route::resource('/subcategories', SubcategoryController::class);
    Route::resource('/products', ProductsController::class);
    Route::resource('/history', HistoryController::class)->only(['index']);
    Route::resource('/backups', BackupsController::class);
    Route::resource('/sales', SalesController::class);
    Route::resource('/pedidos', PedidosController::class);
    Route::post('/backups/{id}/restore', [BackupsController::class, 'restore'])->name('backups.restore');
    Route::post('/backups/createBackup', [BackupsController::class, 'createBackup'])->name('backups.createBackup');
    Route::put('/sales/{sale}/estado', [SalesController::class, 'updateEstado'])->name('sales.updateEstado');
    Route::get('/ofertas', [ProductsController::class, 'ofertas'])->name('ofertas');
    Route::patch('/pedidos/{pedido}/transfer', [PedidosController::class, 'transfer'])->name('pedidos.transfer');

    // Rutas para eliminar imágenes y videos
    Route::delete('products/{producto}/imagen_principal', [ProductsController::class, 'deleteImagenPrincipal'])->name('products.deleteImagenPrincipal');
    Route::delete('products/{producto}/video', [ProductsController::class, 'deleteVideo'])->name('products.deleteVideo');
    Route::delete('products/{producto}/imagenes/{index}', [ProductsController::class, 'deleteImagenes'])->name('products.deleteImagenes');
});
