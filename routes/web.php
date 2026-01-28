<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

// Customer Dashboard
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified', 'role:customer'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

// Super Admin Routes
Route::middleware(['auth', 'verified', 'role:super_admin'])
    ->prefix('superadmin')
    ->name('superadmin.')
    ->group(function () {
        Route::get('/dashboard', \App\Livewire\SuperAdmin\Dashboard::class)->name('dashboard');
    });

// Admin Routes (Client)
Route::middleware(['auth', 'verified', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', \App\Livewire\Admin\Dashboard::class)->name('dashboard');
        Route::get('/products', \App\Livewire\Admin\Products\Index::class)->name('products.index');
    });

require __DIR__.'/auth.php';
