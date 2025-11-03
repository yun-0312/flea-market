<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PurchaseController;

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
    //プロフィール編集画面表示
    Route::get('/mypage/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    //プロフィール更新処理
    Route::patch('/mypage/profile', [ProfileController::class, 'update'])->name('profile.update');

    // お気に入り登録・解除
    Route::post('/favorite/{item}', [FavoriteController::class, 'toggle'])->name('favorite.toggle');

    //コメント機能
    Route::post('item/{item}/comment', [CommentController::class, 'store'])->name('comment.store');

    //商品購入画面
    Route::get('purchase/{item}', [PurchaseController::class, 'show'])->name('purchase.show');

    //商品購入処理
    Route::post('purchase/{item}', [PurchaseController::class, 'store'])->name('purchase.store');

    //配送先住所変更
    Route::get('purchase/address/{item}', [PurchaseController::class, 'editShippingAddress'])->name('purchase.edit');
});