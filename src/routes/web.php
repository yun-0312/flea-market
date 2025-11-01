<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ItemController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// ログイン
Route::post('login', [LoginController::class, 'store'])->name('login');

//商品一覧（ログイン前）
Route::get('/', [ItemController::class, 'index'])->name('item.index');

// ログイン後
Route::middleware('auth')->group(function() {
    Route::get('/mypage/profile', [UserController::class, 'update']);
});