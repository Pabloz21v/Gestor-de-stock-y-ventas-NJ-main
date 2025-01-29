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

use App\Models\Categories;
// Rutas no autenticadas
Route::get('/', [DashboardController::class, 'index']);
Route::permanentRedirect('/register', '/');


// Route::get('/', function () {
//     $categories = Categories::with('subcategories.products')->get();
//     return Inertia::render('Menu', ['categories' => $categories]);
// });


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
    Route::post('/backups/{id}/restore', [BackupsController::class, 'restore'])->name('backups.restore');
    Route::post('/backups/createBackup', [BackupsController::class, 'createBackup'])->name('backups.createBackup');
    Route::put('/sales/{sale}/estado', [SalesController::class, 'updateEstado'])->name('sales.updateEstado');

    // Route::delete('products/{producto}/imagen_principal', [ProductsController::class, 'deleteMainPhoto'])->name('products.deleteMainPhoto');

    // Route::delete('products/{producto}/imagen-principal', [ProductsController::class, 'deleteMainPhoto'])->name('products.deleteMainPhoto');
    // Route::delete('products/{producto}/video', [ProductsController::class, 'deleteVideo'])->name('products.deleteVideo');
    // Route::delete('products/{producto}/imagenes/{index}', [ProductsController::class, 'deleteExtraPhoto'])->name('products.deleteExtraPhoto');
});
