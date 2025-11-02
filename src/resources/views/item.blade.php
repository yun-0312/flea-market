@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item.css') }}" />
@endsection

@section('header')
@include('layouts.header_item')
@endsection

@section('content')
<div class="item">
    <div class="item__container">
        <div class="item__image-wrap">
            <img src="{{ asset('storage/images/items/' . $item['image_url']) }}" alt="商品画像" class="item__image">
        </div>
        <div class="item__text-detail">
            <h2 class="item__name">
                {{ $item['name'] }}
                @if ($item->is_sold)
                <span class="sold__label">sold</span>
                @endif
            </h2>
            <p class="item__brand">
                {{ empty($item['brand']) || $item['brand'] === 'なし' ? 'ブランド名なし' : $item['brand'] }}
            </p>
            <p class="item__price">
                <span class="price__item">￥</span>
                {{ number_format($item['price']) }}
                <span class="price__item"> (税込)</span>
            </p>
            <div class="item__icons">
                <div class="item__icon">
                    @if (Auth::check())
                    <form action="{{ route('favorite.toggle', $item) }}" method="POST">
                        @csrf
                        <button class="favorite-btn" type="submit">
                            @if (auth()->user()->favorites->contains($item->id))
                            <img src="{{ asset('img/星アイコン赤.png') }}" alt="お気に入り" class="item__icon-img">
                            @else
                            <img src="{{ asset('img/星アイコン8.png') }}" alt="お気に入り" class="item__icon-img">
                            @endif
                        </button>
                    </form>
                    @else
                    <a href="{{ route('login') }}">
                        <img src="{{ asset('img/星アイコン8.png') }}" alt="お気に入り" class="item__icon-img">
                    </a>
                    @endif
                    <p class="item__icon-count">{{ $item->favoritedBy->count() ?? 0 }}</p>
                </div>
                <div class="item__icon">
                    <img src="{{ asset('img/ふきだしのアイコン.png') }}" alt="コメント" class="item__icon-img">
                    <p class="item__icon-count">{{ $item->comments->count() }}</p>
                </div>
            </div>
            <form action="" class="purchase-form">
                @csrf
                <input type="submit" class="purchase-form__btn" value="購入手続きへ">
            </form>
            <div class="item__section">
                <h3 class="item__section-title">商品説明</h3>
                <p class="item__description">{{ $item['description'] }}</p>
            </div>
            <div class="item__section">
                <h3 class="item__section-title">商品の情報</h3>
                <div class="item__information">
                    <h4 class="item__information-title">カテゴリー</h4>
                    <div class="item__information-categories">
                        <p class="item__information-category">洋服</p>
                        <p class="item__information-category">メンズ</p>
                        <p class="item__information-category">メンズ</p>
                        <p class="item__information-category">メンズ</p>
                        <p class="item__information-category">メンズ</p>
                        <p class="item__information-category">メンズ</p>
                        <p class="item__information-category">メンズ</p>
                    </div>
                </div>
                <div class="item__information">
                    <h4 class="item__information-title">商品の状態</h4>
                    <p class="item__information-condition"> {{ $item->condition_label }}
                    </p>
                </div>
            </div>
            <div class="comment__section">
                <h3 class="comment__section-title">
                    コメント
                    ({{ $item->comments->count() }})
                </h3>
                @forelse ($item->comments as $comment)
                <div class="comment">
                    <div class="comment__user">
                        <div class="comment__icon"></div>
                        <span class="comment__name">{{ $comment->user->name}}
                        </span>
                    </div>
                    <p class="comment__text">{{ $comment->comment }}</p>
                </div>
                @empty
                <p>まだコメントはありません</p>
                @endforelse
                <form action="{{ route('comments.store', $item) }}" method="post" class="comment-form">
                    @csrf
                    <label for="comment" class="comment-form__label">商品へのコメント</label>
                    <textarea name="comment" id="comment" class="comment-form__textarea">{{ old('comment') }}</textarea>
                    @error('comment')
                    <p class="comment-form__error-message">
                        {{ $message }}
                    </p>
                    @enderror
                    <button type="submit" class="comment-form__btn">コメントを送信する</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection