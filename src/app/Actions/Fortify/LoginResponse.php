<?php

namespace App\Actions\Fortify;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        // ログイン中のユーザーを取得
        $user = $request->user();

        // メール未認証なら認証ページへリダイレクト
        if (!$user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }

        // 通常はトップページへ
        return redirect()->intended('/');
    }
}
