@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}" />
@endsection

@section('header')
@include('layouts.header_item')
@endsection

@section('content')
<div class="mypage__profile">
    <div class="mypage__image-section">
        <div class="mypage__image-circle">
            {{-- プロフィール画像がある場合は表示 --}}
            @if($profile && $profile->image_url)
            <img src="{{ asset('storage/images/profile/' . $profile->image_url) }}" alt="プロフィール画像" class="mypage__image-preview">
            @else
            <div class="mypage__image-placeholder"></div>
            @endif
        </div>
        <div class="mypage__user-name">{{ $user->name }}</div>
    </div>
    <a href="{{ route('profile.edit') }}" class="edit-profile__link">プロフィールを編集</a>
</div>
<div class="content__link">
    <a href="{{ route('mypage.show', ['page' => 'sell']) }}" class="content-link__item {{ $page === 'sell' ? 'active' : '' }}">出品した商品</a>
    <a href="{{ route('mypage.show', ['page' => 'buy']) }}" class="content-link__item {{ $page === 'buy' ? 'active' : '' }}">購入した商品</a>
</div>
<div class="items">
    @forelse ($items as $item)
    @if ($item)
    <a href="{{ route('item.show', ['item' => $item->id]) }}" class="items__card-link">
        <div class="items__card">
            <img src="{{ asset('storage/images/items/' . $item->image_url) }}" alt="商品画像" class="items__image">
            <p class="items__name">
                {{ $item->name }}
                @if ($item->is_sold)
                <span class="sold__label">SOLD</span>
                @endif
            </p>
        </div>
    </a>
    @endif
    @empty
    <p class="items__empty">該当する商品はありません。</p>
    @endforelse
</div>

@endsection