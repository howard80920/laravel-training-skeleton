<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Shared;
use App\Http\Controllers\Office;

Route::post('/change-locale', Shared\ChangeLocale::class)->name('change-locale');
Route::get('/debug', Shared\ShowDebug::class);

Route::get('/', Office\ShowHome::class)->name('index');
Route::get('/error', Office\ShowError::class)->name('error');
Route::get('/login', [ Office\AuthController::class, 'loginView' ])->name('login');
Route::post('/login', [ Office\AuthController::class, 'loginSubmit' ])->name('login.submit');
Route::get('/logout', [ Office\AuthController::class, 'logout' ])->name('logout');
