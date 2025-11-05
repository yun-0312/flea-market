<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Item;
use App\Models\ShippingAddress;
use App\Http\Requests\PurchaseRequest;
use App\Http\Requests\AddressRequest;

class PurchaseController extends Controller
{
    public function show (Item $item) {
        if ($item->is_sold) {
            return redirect()->route('items.index')
                ->with('error', 'この商品は既に売約済みです。');
        }
        $user = auth()->user();
        $sessionAddress = session('shipping_address');
        // セッションに一時住所があればそちらを優先
        if ($sessionAddress) {
            $address = (object) [
                'post_code' => $sessionAddress['post_code'],
                'address' => $sessionAddress['address'],
                'building' => $sessionAddress['building'] ?? null,
            ];
        } else {
            // なければプロフィール住所を使用
            $address = $user->profile;
        }
        return view('purchase', compact('item', 'user', 'address'));
    }

    public function editShippingAddress (Item $item) {
        $user = auth()->user();
        return view('shipping_address', compact('item', 'user'));
    }

    public function saveShippingAddress  (AddressRequest $request, Item $item) {
        session([
            'shipping_address' => [
                'post_code' => $request->post_code,
                'address' => $request->address,
                'building' => $request->building,
            ],
        ]);
        return redirect()->route('purchase.show', ['item' => $item->id])->with('success', '配送先を変更しました');
    }

    public function store (PurchaseRequest $request, Item $item){
        if ($item->is_sold) {
            return redirect()->route('items.index')
                ->with('error', 'この商品は既に売約済みです。');
        }
        $user = auth()->user();
        $profile = $user->profile;
        $shippingData = session('shipping_address');
        $shippingAddress = ShippingAddress::create([
            'user_id' => $user->id,
            'post_code' => $shippingData['post_code'] ?? $profile->post_code,
            'address' => $shippingData['address'] ?? $profile->address,
            'building' => $shippingData['building'] ?? $profile->building,
        ]);
        // shipping_address_id をリクエストにマージしてバリデーション
        $request->merge(['shipping_address_id' => $shippingAddress->id]);
        $validated = $request->validate($request->rules());
        Purchase::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
            'shipping_address_id' => $shippingAddress->id,
            'payment_method' => $validated['payment_method'],
        ]);
        //購入完了後セッション削除
        session()->forget('shipping_address');
        return redirect('/')->with('success', '購入が完了しました');
    }
}
