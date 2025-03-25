<?php

use App\Livewire\ManagePermission;
use App\Livewire\ManageRole;
use App\Livewire\ManageUser;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware(['auth'])->group(function () {

    Route::view('dashboard', 'dashboard')
        ->middleware(['verified'])
        ->name('dashboard');

    Route::get('users', ManageUser::class)
        ->middleware(['can:read user'])
        ->name('users');

    Route::get('roles', ManageRole::class)
        ->middleware(['can:read role'])
        ->name('roles');

    Route::get('permissions', ManagePermission::class)
        ->middleware(['can:read permission'])
        ->name('permissions');

    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
