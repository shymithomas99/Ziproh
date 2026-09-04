<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\NavigationController;
use Illuminate\Support\Facades\Route;


Route::middleware('guest')->group(function () {

    Route::get('/login', [LoginController::class, 'showLoginForm'])
        ->name('login');

    Route::post('/login', [LoginController::class, 'login'])
        ->name('login.submit');
});

Route::middleware('auth')->group(function () {

    Route::post('/logout', [LoginController::class, 'logout'])
        ->name('logout');

    Route::get('/', [HomeController::class, 'index'])
        ->name('home');
    // Navigation Routes
    Route::resource('navigations', NavigationController::class);
    // Banner Routes
    Route::get(
        'banners/{type}',
        [BannerController::class, 'index']
    )->name('banners.index');

    Route::get(
        'banners/{type}/create',
        [BannerController::class, 'create']
    )->name('banners.create');

    Route::post(
        'banners/{type}',
        [BannerController::class, 'store']
    )->name('banners.store');

    Route::get(
        'banners/{type}/{banner}',
        [BannerController::class, 'show']
    )->name('banners.show');

    Route::get(
        'banners/{type}/{banner}/edit',
        [BannerController::class, 'edit']
    )->name('banners.edit');

    Route::put(
        'banners/{type}/{banner}',
        [BannerController::class, 'update']
    )->name('banners.update');

    Route::delete(
        'banners/{type}/{banner}',
        [BannerController::class, 'destroy']
    )->name('banners.destroy');
});
