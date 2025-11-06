@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}" />
@endsection

@section('header')
@include('layouts.header_item')
@endsection

@section('content')
<div class="purchase__container">
    <form action="{{ route('purchase.store', $item) }}" class="purchase-form" method="post">
        @csrf
        <div class="purchase__information">
            <div class="purchase__information-item">
                <div class="purchase__information-image-wrap">
                    <img src="{{ asset('storage/images/items/' . $item['image_url']) }}" alt="商品画像" class="purchase__information-image" />
                </div>
                <div class="purchase__information-details">
                    <h3 class="purchase__information-item-name">{{ $item->name }}</h3>
                    <p class="purchase__information-item-price"><span class="price__item">￥</span>{{ number_format($item['price']) }}</p>
                </div>
            </div>
            <div class="purchase__information-item">
                <h4 class="purchase__information-item-payment-method">支払い方法</h4>
                <select name="payment_method" id="payment_method" class="purchase__information-payment-method">
                    <option value="1" {{ old('payment_method') == 1 ? 'selected' : '' }}>コンビニ払い</option>
                    <option value="2" {{ old('payment_method') == 2 ? 'selected' : '' }}>カード支払い</option>
                </select>
                @error('payment_method')
                <p class="purchase-form__error-message">
                    {{ $message }}
                </p>
                @enderror
            </div>
            <div class="purchase__information-item">
                <div class="purchase__information-header">
                    <h4 class="purchase__information-shipping-address">配送先</h4>
                    <a href="{{ route('purchase.edit', ['item' => $item->id]) }}" class="purchase__information-change-link">変更する</a>
                </div>
                @if($address)
                <p class="purchase__information-post-code">〒{{ $address->post_code }}</p>
                <p class="purchase__information-address">{{ $address->address }} {{ $address->building }}</p>
                @else
                <p class="purchase__information-post-code">配送先が設定されていません</p>
                @endif
                @error('shipping_address_id')
                <p class="purchase-form__error-message">
                    {{ $message }}
                </p>
                @enderror
            </div>
        </div>
        <div class="purchase__summary">
            <table class="purchase__table">
                <tr>
                    <th class="purchase__table-header">商品代金</th>
                    <td class="purchase__table-data"><span class="price__item">￥</span>{{ number_format($item['price']) }}</td>
                </tr>
                <tr>
                    <th class="purchase__table-header">支払い方法</th>
                    <td class="purchase__table-data" id="payment_display">
                        @if(old('payment_method') == 2)
                        カード支払い
                        @else
                        コンビニ払い
                        @endif
                    </td>
                </tr>
            </table>
            <input type="submit" class="purchase-form__btn" value="購入する">
        </div>
    </form>
</div>
<script>
    const paymentSelect = document.getElementById('payment_method');
    const paymentDisplay = document.getElementById('payment_display');
    paymentSelect.addEventListener('change', function() {
        const selectedText = paymentSelect.options[paymentSelect.selectedIndex].text;
        paymentDisplay.textContent = selectedText;
    });
</script>
@endsection