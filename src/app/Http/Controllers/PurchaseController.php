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
        $address = $user->profile;
        return view('purchase', compact('item', 'user'));
    }

    public function editShippingAddress (Item $item) {
        return view('shipping_address', compact('item'));
    }

    public function updateShippingAddress  (AddressRequest $request, Item $item) {
        ShippingAddress::create([
            'user_id' => auth()->id(),
            'post_code' => $request->post_code,
            'address' => $request->address,
            'building' => $request->building, 
        ]);
        return redirect()->route('purchase.show', ['item' => $item->id])->with('success', '配送先を変更しました');
    }

    public function store (PurchaseRequest $request, Item $item){
        Purchase::create([
            'user_id' => auth()->id(),
            'item_id' => $item->id,
            'shipping_address_id' => $request->shopping_address_id,
            'payment_method' => $request->payment_method,
        ]);
        return redirect('/')->with('success', '購入が完了しました');
    }
}
