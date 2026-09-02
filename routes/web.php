<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



Route::get('/', [App\Http\Controllers\FrontendController::class, 'index'])->name('index');
