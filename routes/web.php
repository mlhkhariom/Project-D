<?php

use Illuminate\Support\Facades\Route;

Route::get('/', \App\Livewire\Public\Home::class)->name('home');
Route::get('/shop', \App\Livewire\Public\Shop::class)->name('shop');
Route::get('/cart', \App\Livewire\Public\Cart::class)->name('cart');

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
        Route::get('/themes', \App\Livewire\SuperAdmin\Themes::class)->name('themes');
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
