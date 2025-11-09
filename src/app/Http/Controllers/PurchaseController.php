<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Item;
use App\Models\ShippingAddress;
use App\Http\Requests\PurchaseRequest;
use App\Http\Requests\AddressRequest;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PurchaseController extends Controller
{
    public function show (Item $item) {
        if ($item->is_sold) {
            return redirect()->route('items.index')
                ->with('error', 'この商品は既に売約済みです。');
        }
        $user = auth()->user();
        $sessionAddress = session('shipping_address');
        $sessionPayment = session('payment_method');
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
        return view('purchase', compact('item', 'user', 'address', 'sessionPayment'));
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
        if ($request->has('payment_method')) {
            session(['payment_method' => $request->payment_method]);
        }
        return redirect()->route('purchase.show', ['item' => $item->id])->with('success', '配送先を変更しました');
    }

    public function store (PurchaseRequest $request, Item $item){
        $item->refresh();
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
        Purchase::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
            'shipping_address_id' => $shippingAddress->id,
            'payment_method' => $request->payment_method,
        ]);
        // Stripe Checkout（決済画面だけ開く）
        Stripe::setApiKey(config('services.stripe.secret'));
        // Stripe セッション作成
        $session = Session::create([
            'payment_method_types' => ['card'], // 今はカードのみ
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => $item->name,
                    ],
                    'unit_amount' => $item->price,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',

            // このURLにリダイレクト（決済成功の代わりに戻るだけ）
            'success_url' => route('stripe.success', ['item' => $item->id]),
            'cancel_url' => route('stripe.cancel', ['item' => $item->id]),
        ]);
        //購入完了後セッション削除
        session()->forget('shipping_address');
        // return redirect('/')->with('success', '購入が完了しました');
        return redirect($session->url);
    }

    //Stripe成功時の処理
    public function success(Request $request, Item $item) {
        return redirect()->route('item.show', $item->id)
            ->with('success', '購入が完了しました');
    }

    //Stripeキャンセル時
    public function cancel(Item $item)
    {
        return redirect()->route('item.show', $item->id)->with('error', '決済がキャンセルされました。もう一度お試しください。');
    }
}
