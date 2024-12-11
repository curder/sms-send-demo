<?php

use Livewire\Volt\Volt;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/register');

Volt::route('verify-codes', 'pages.verify-codes')
    ->name('verify-codes');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
