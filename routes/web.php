<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// 根網址
Route::get(
    '/',
    fn () => app()->isLocal() ? view('welcome') : response('Hello World')
)->name('index');

/**
 * laravel若系統session整個失效，會導致沒辦法針對特定的guard做跳轉，
 * 定義一個未知錯誤的路由，提供跳轉，避免跳轉至未定義路由而噴錯
 * @see App\Exceptions\Handler unauthenticated
 */
Route::get(
    '/woops',
    fn () => response('Woops! Something wrong :( Please re-enter your url.')
)->name('woops');

// 運作狀態檢查
Route::get(
    '/healthcheck',
    fn () => response('OK')
)->name('healthcheck');
