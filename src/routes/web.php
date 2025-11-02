<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\CommentController;

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

//商品詳細
Route::get('/item/{item}',[ItemController::class, 'show'])->name('item.show');

// ログイン後
Route::middleware('auth')->group(function() {
    //プロフィール登録・修正画面
    Route::get('/mypage/profile', [UserController::class, 'update']);
    // お気に入り登録・解除
    Route::post('/favorite/{item}', [FavoriteController::class, 'toggle'])
        ->name('favorite.toggle');
    //コメント機能
    Route::post('items/{item}/comments', [CommentController::class, 'store'])->name('comments.store');
    //商品購入画面
    Route::get('purchase/{item}', [])
});