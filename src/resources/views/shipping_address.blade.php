@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/shipping_address.css') }}">
@endsection

@section('header')
@include('layouts.header')
@endsection

@section('content')
<div class="content-wrapper">
    <h2 class="edit-address-form__heading">住所の変更</h2>
    <form class="form" action="{{ route('purchase.update', ['item' => $item->id]) }}" method="post">
        @csrf
        <div class="edit-address-form__group">
            <label class="edit-address-form__label" for="post_code">郵便番号</label>
            <input type="text" id="post_code" class="edit-address-form__input" name="post_code" value="{{ old('post_code') }}">
            @error('post_code')
            <p class="edit-address-form__error-message">
                {{ $message }}
            </p>
            @enderror
        </div>
        <div class="edit-address-form__group">
            <label class="edit-address-form__label" for="address">住所</label>
            <input type="text" id="address" class="edit-address-form__input" name="address" value="{{ old('address') }}">
            @error('address')
            <p class="edit-address-form__error-message">
                {{ $message }}
            </p>
            @enderror
        </div>
        <div class="edit-address-form__group">
            <label class="edit-address-form__label" for="building">建物名</label>
            <input type="text" id="building" class="edit-address-form__input" name="building" value="{{ old('building') }}">
            @error('building')
            <p class="edit-address-form__error-message">
                {{ $message }}
            </p>
            @enderror
        </div>
        <div class="edit-address-form__group">
            <input type="submit" class="edit-address-form__btn" value="更新する">
        </div>
    </form>
</div>
@endsection