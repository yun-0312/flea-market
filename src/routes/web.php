<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
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
Route::get('/', [ItemController::class, 'index'])->name('items.index');

//商品詳細
Route::get('/item/{item}',[ItemController::class, 'show'])->name('item.show');

//メール認証画面
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

//メール認証リンククリック時
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    $user = $request->user();
    if (!$user->profile) {
        return redirect()->route('profile.edit')
            ->with('success', 'メール認証が完了しました。プロフィールを登録してください。');
    }
    return redirect()->route('mypage.show');
})->middleware(['auth', 'signed'])->name('verification.verify');

//認証メール再送信
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', '確認メールを再送しました。');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// ログイン後
Route::middleware(['auth', 'verified'])->group(function() {
    //プロフィール画面
    Route::get('/mypage',[ProfileController::class, 'show'])->name('mypage.show');

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

    //配送先住所変更画面
    Route::get('purchase/address/{item}', [PurchaseController::class, 'editShippingAddress'])->name('purchase.edit');

    //配送先住所変更
    Route::post('purchase/address/{item}', [PurchaseController::class, 'saveShippingAddress'])
    ->name('purchase.save');

    //Stripe決済画面
    Route::get('/stripe/success/{item}', [PurchaseController::class, 'success'])->name('stripe.success');

    //商品出品画面
    Route::get('/sell', [ItemController::class, 'create'])->name('item.create');

    //商品出品処理
    Route::post('/sell', [ItemController::class, 'store'])->name('item.store');
});