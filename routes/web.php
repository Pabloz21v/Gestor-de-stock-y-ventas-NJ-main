<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\DishesController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\BackupsController;

use App\Models\Categories;
// Rutas no autenticadas
Route::get('/', [DashboardController::class, 'index']);
Route::permanentRedirect('/register', '/');


// Route::get('/', function () {
//     $categories = Categories::with('subcategories.dishes')->get();
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
    Route::resource('/dishes', DishesController::class);
    Route::resource('/history', HistoryController::class)->only(['index']);
    Route::resource('/backups', BackupsController::class);
    Route::post('/backups/{id}/restore', [BackupsController::class, 'restore'])->name('backups.restore');
    Route::post('/backups/createBackup', [BackupsController::class, 'createBackup'])->name('backups.createBackup');
});
