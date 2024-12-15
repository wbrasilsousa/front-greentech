<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\CustomRegistrationController;
use App\Http\Controllers\SupplierAuthController;
use App\Http\Controllers\ProductAuthController;

Route::get('/', function () {
    return redirect('login');
});

/**
 * Rotas customizadas (Auth) para Autenticação
 */
Route::get('/login', [CustomAuthController::class, 'showLoginForm'])->name('showLoginForm');
Route::post('/login', [CustomAuthController::class, 'login'])->name('login');
Route::get('/logout', [CustomAuthController::class, 'logout'])->name('logout');

Route::get('/register', [CustomRegistrationController::class, 'showRegistrationForm'])->name('showRegistrationForm');
Route::post('/register', [CustomRegistrationController::class, 'register'])->name('register');


/**
 * Guard Customizado para autenticar com API
 */
Route::middleware(['isAdmin'])->group(function () {
    
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    
    /**
     * Rotas Fornecedores
     */
    Route::prefix('suppliers')->group(function () {
        Route::get('/list', [SupplierAuthController::class, 'index'])->name('supplier.index');

        Route::get('/add', [SupplierAuthController::class, 'add'])->name('supplier.add');
        Route::post('/save', [SupplierAuthController::class, 'save'])->name('supplier.save');

        Route::get('/edit/{id}', [SupplierAuthController::class, 'edit'])->name('supplier.edit');
        Route::post('/update', [SupplierAuthController::class, 'update'])->name('supplier.update');

        Route::get('/delete/{id}', [SupplierAuthController::class, 'delete'])->name('supplier.delete');
    });

    /**
     * Rotas Produtos
     */
    Route::prefix('products')->group(function () {
        Route::get('/list', [ProductAuthController::class, 'index'])->name('product.index');

        Route::get('/add', [ProductAuthController::class, 'add'])->name('product.add');
        Route::post('/save', [ProductAuthController::class, 'save'])->name('product.save');

        Route::get('/edit/{id}', [ProductAuthController::class, 'edit'])->name('product.edit');
        Route::post('/update', [ProductAuthController::class, 'update'])->name('product.update');

        Route::get('/delete/{id}', [ProductAuthController::class, 'delete'])->name('product.delete');
    });

});


