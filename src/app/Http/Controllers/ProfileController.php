<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\Item;
use App\Models\Purchase;
use App\Http\Requests\ProfileRequest;


class ProfileController extends Controller
{
    public function show (Request $request) {
        $page = $request->query('page', 'sell');
        $user = auth()->user();
        $profile = $user->profile;
        if ($page === 'sell') {
            $items = Item::where('user_id', $user->id)->get();
        } elseif ($page === 'buy') {
            $purchasedItemIds = Purchase::where('user_id', $user->id)->pluck('item_id');
            $items = Item::whereIn('id', $purchasedItemIds)->get();
        } else {
            $items = collect();
        }
        return view('mypage.mypage', compact('user', 'profile', 'page', 'items'));
    }

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
