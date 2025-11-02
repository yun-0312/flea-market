<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class FavoriteController extends Controller
{
    public function toggle(Item $item) {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        $user = auth()->user();
        if ($user->favorites()->where('item_id', $item->id)->exists()) {
            $user->favorites()->detach($item->id);//削除
        } else {
            $user->favorites()->attach($item->id);//追加
        }
        return back();
    }
}
