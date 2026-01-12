@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/transaction.css') }}">
@endsection

@section('header')
@include('layouts.header_transaction')
@endsection

@section('content')
<div class="content-wrapper">
    <div class="sidebar">
        <h2 class="sidebar__header">その他の取引</h2>
        @foreach ($sidebarTransactions as $sidebarTransaction)
            <a href="{{ route('transactions.show', $sidebarTransaction) }}" class="transaction__link {{ $sidebarTransaction->id === $transaction->id ? 'active' : '' }}">{{ $sidebarTransaction->purchase->item->name }}</a>
        @endforeach
    </div>
    <div class="main-content">
        <div class="main-content__header-wrap">
            <img src="{{ asset('storage/images/profiles/' . optional($partner->profile)->image_url) }}" class="partner-user__icon" alt="ユーザー画像">
            <h1 class="main-content__header">
                「{{ $partner->name }}」さんとの取引画面
            </h1>
            @if ($transaction->isBuyer($user) && $transaction->status === 'trading')
                <form method="POST" action="{{ route('transactions.complete', $transaction) }}">
                @csrf
                <button type="submit" class="btn btn-danger">
                    取引を完了する
                </button>
                </form>
            @endif
        </div>
        <div class="item__wrap">
            <div class="item-image__container">
                <img src="{{ asset('storage/images/items/' . optional($transaction->purchase->item)->image_url) }}" class="item-image">
            </div>
            <div class="item-info">
                <h2 class="item-name">{{ $transaction->purchase->item->name }}</h2>
                <p class="item-price">￥{{ $transaction->purchase->item->price }}</p>
            </div>
        </div>
        <div class="message__wrap">
            @foreach ($messages as $message)
                @if ($message->user_id !== $user->id)
                    <div class="partner-message__wrap">
                        <div class="user-info">
                            <img src="{{ asset('storage/images/profiles/' . optional($partner->profile)->image_url) }}" class="user__icon">
                            <p class="user-info__name">{{ $transaction->partnerUser($user)->name }}</p>
                        </div>
                        <div class="message-content">
                            {{ $message->message }}
                        </div>
                    </div>
                @else
                    <div class="user-message__wrap">
                        <div class="user-info">
                            <p class="user-info__name">{{ $user->name }}</p>
                            <img src="{{ asset('storage/images/profiles/' . optional($user->profile)->image_url) }}" class="user__icon">
                        </div>
                        @if (session('updated_message_id') === $message->id && $errors->any())
                            <ul class="message-error">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                        <div class="message-content">
                            <form id="update-{{ $message->id }}" method="POST" action="{{ route('transactions.messages.update', $message) }}" enctype="multipart/form-data" class="message-form">
                                @csrf
                                @method('PUT')
                                <textarea name="message" class="message-form__textarea" rows="1" oninput="autoResize(this)">{{ old('message', $message->message) }}</textarea>
                                <div class="update-image__container">
                                    <label class="update-image__button">
                                        画像を変更
                                        <input type="file" name="image" hidden>
                                    </label>
                                    @if ($message->image_url)
                                        <label class="remove-image">
                                            <input type="checkbox" name="remove_image" value="1">
                                            画像を削除
                                        </label>
                                    @endif
                                </div>
                                @if ($message->image_url)
                                    <img src="{{ asset('storage/images/transaction_messages/' . $message->image_url) }}" alt="メッセージ画像" class="message-image">
                                @endif
                            </form>
                        </div>
                        <div class="message-actions">
                            <button class="message-form__button" form="update-{{ $message->id }}">編集</button>
                            <form method="POST" action="{{ route('transactions.messages.destroy', $message) }}" class="message-form">
                                @csrf
                                @method('DELETE')
                                <button class="message-form__button">削除</button>
                            </form>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
        <div class="create-form__wrap">
            <div class="form__error">
                @error('message')
                    <p class="form__error-message">
                        {{ $message }}
                    </p>
                @enderror
                @error('image_url')
                    <p class="form__error-message">
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <form method="POST"
                action="{{ route('transactions.messages.store', $transaction) }}"
                enctype="multipart/form-data"
                class="message-form__create">
                @csrf
                <input type="text" name="message" class="message-form__create-input" placeholder="取引メッセージを記入してください">
                <label class="image-upload">
                    画像を追加
                    <input type="file" name="image" hidden>
                </label>
                <button type="submit" class="create__button"></button>
            </form>
        </div>
    </div>
</div>
<script>
function autoResize(textarea) {
    textarea.style.height = 'auto';
    textarea.style.height = textarea.scrollHeight + 'px';
}

document.querySelectorAll('.message-form__textarea').forEach(t => {
    autoResize(t);
});
</script>
@endsection