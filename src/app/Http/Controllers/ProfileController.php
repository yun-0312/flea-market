<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use App\Http\Requests\ProfileRequest;

class ProfileController extends Controller
{
    public function edit ()
    {
        $user = auth()->user();
        return view('mypage.edit_profile', compact('user'));
    }

    public function update (ProfileRequest $request)
    {
        $user = auth()->user();
        $user->update($request->validated());

        return redirect ()
            ->route('profile.edit')
            ->with('success', 'プロフィールを更新しました');
    }
}
