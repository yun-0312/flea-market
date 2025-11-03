@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/shipping_address.css') }}">
@endsection

@section('header')
@include('layouts.header')
@endsection

@section('content')
<div class="content-wrapper">
    <h2 class="shipping-address-form__heading">住所の変更</h2>
    <form class="form" action="{{ route('.update') }}" method="post">
        @csrf
        <input type="file" name="image_url">
        <button>画像を選択する</button>
        <div class="edit-profile-form__group">
            <label class="edit-profile-form__label" for="name">ユーザー名</label>
            <input type="text" id="name" class="edit-profile-form__input" name="name" value="{{ old('name') }}">
            @error('name')
            <p class="edit-profile-form__error-message">
                {{ $message }}
            </p>
            @enderror
        </div>
        <div class="edit-profile-form__group">
            <label class="edit-profile-form__label" for="post_code">郵便番号</label>
            <input type="text" id="post_code" class="edit-profile-form__input" name="post_code" value="{{ old('post_code') }}">
            @error('post_code')
            <p class="edit-profile-form__error-message">
                {{ $message }}
            </p>
            @enderror
        </div>
        <div class="edit-profile-form__group">
            <label class="edit-profile-form__label" for="address">住所</label>
            <input type="text" id="address" class="edit-profile-form__input" name="address" value="{{ old('address') }}">
            @error('address')
            <p class="edit-profile-form__error-message">
                {{ $message }}
            </p>
            @enderror
        </div>
        <div class="edit-profile-form__group">
            <label class="edit-profile-form__label" for="building">建物名</label>
            <input type="text" id="building" class="edit-profile-form__input" name="building" value="{{ old('building') }}">
            @error('building')
            <p class="edit-profile-form__error-message">
                {{ $message }}
            </p>
            @enderror
        </div>
        <div class="edit-profile-form__group">
            <input type="submit" class="edit-profile-form__btn" value="更新する">
        </div>
    </form>
</div>
@endsection