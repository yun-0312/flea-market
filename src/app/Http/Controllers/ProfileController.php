<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Profile;
use App\Models\Item;
use App\Models\Purchase;
use App\Models\Transaction;
use App\Http\Requests\ProfileRequest;


class ProfileController extends Controller
{
    public function show (Request $request) {
        $page = $request->query('page', 'sell');
        $user = auth()->user()->load('receivedReviews');
        $profile = $user->profile;
        $items = match ($page) {
            'sell' => Item::where('user_id', $user->id)->get(),
            'buy' => Item::whereIn(
                'id',
                Purchase::where('user_id', $user->id)->pluck('item_id')
            )->get(),
            'trading' => Item::tradingAndAwaitingForUser($user->id)->get(),
            default => collect(),
        };
        $tradingTransactions = Transaction::activeForUserWithUnreadCount($user->id)->get();
        $tradingUnreadCount = $tradingTransactions->sum('unread_count');
        $itemUnreadCounts = $tradingTransactions
            ->groupBy('purchase.item_id')
            ->map(fn ($txs) => $txs->sum('unread_count'));
        $tradingTransactions = Transaction::activeForUserWithUnreadCount($user->id)
            ->with('purchase.item')
            ->get()
            ->keyBy(fn ($t) => $t->purchase->item_id);
        return view('mypage.mypage', compact('user', 'profile', 'page', 'items', 'tradingUnreadCount', 'itemUnreadCounts', 'tradingTransactions'));
    }

    public function edit ()
    {
        $user = auth()->user();
        $profile = $user->profile ?? new Profile();
        return view('mypage.edit_profile', compact('profile'));
    }

    public function update(ProfileRequest $request)
    {
        $user = auth()->user();
        $profile = $user->profile ?? new Profile(['user_id' => $user->id]);
        $profile->fill($request->validated());
        if ($request->hasFile('image_url')) {
            if ($profile->image_url) {
                $oldPath = 'public/images/profiles/' . $profile->image_url;
                if (Storage::exists($oldPath)) {
                    Storage::delete($oldPath);
                }
            }
            $path = $request->file('image_url')->store('public/images/profiles');
            $profile->image_url = basename($path);
        }
        $profile->save();
        $user->update(['name' => $request->input('name')]);
        return redirect()->route('profile.edit')->with('success', 'プロフィールを更新しました');
    }
}
