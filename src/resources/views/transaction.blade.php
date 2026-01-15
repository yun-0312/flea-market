@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/transactions/transaction.css') }}">
<link rel="stylesheet" href="{{ asset('css/transactions/review_modal.css') }}">
<link rel="stylesheet" href="{{ asset('css/transactions/awaiting_seller_review_modal.css') }}">
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
                <button type="submit" class="complete__button">
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
                    {{-- 相手側メッセージ --}}
                    <div class="partner-message__wrap" id="message-{{ $message->id }}">
                        <div class="user-info">
                            <img src="{{ asset('storage/images/profiles/' . optional($partner->profile)->image_url) }}" class="user__icon">
                            <p class="user-info__name">{{ $transaction->partnerUser($user)->name }}</p>
                        </div>

                        <div class="message-content">
                            {{ $message->message }}
                        </div>

                        @if ($message->image_url)
                            <img src="{{ asset('storage/images/transaction_messages/' . $message->image_url) }}" class="message-image">
                        @endif
                    </div>

                @else
                    {{-- 自分側メッセージ --}}
                    <div class="user-message__wrap" id="message-{{ $message->id }}">
                        <div class="user-info">
                            <p class="user-info__name">{{ $user->name }}</p>
                            <img src="{{ asset('storage/images/profiles/' . optional($user->profile)->image_url) }}" class="user__icon">
                        </div>

                        {{-- 通常表示（吹き出し） --}}
                        <div class="message-content">
                            {{ $message->message }}
                        </div>

                        @if ($message->image_url)
                            <img src="{{ asset('storage/images/transaction_messages/' . $message->image_url) }}" class="message-image">
                        @endif

                        {{-- 編集・削除ボタン --}}
                        <div class="message-actions">
                            <button class="message-form__button edit-toggle" data-id="{{ $message->id }}">編集</button>
                            <button class="message-form__button" form="delete-{{ $message->id }}">削除</button>
                        </div>

                        {{-- 編集フォーム（最初は非表示） --}}
                        <div class="edit-form" id="edit-form-{{ $message->id }}" style="display:none;">
                            <form method="POST" action="{{ route('transactions.messages.update', $message) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <textarea name="messages[{{ $message->id }}]"
                                        class="message-form__textarea auto-resize"
                                        rows="1">{{ old("messages.$message->id", $message->message) }}</textarea>

                                <div class="update-image__container">
                                    <label class="update-image__button">
                                        ＋
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
                                    <img src="{{ asset('storage/images/transaction_messages/' . $message->image_url) }}" class="message-image">
                                @endif

                                <div class="edit-actions">
                                    <button type="submit" class="message-form__button">保存</button>
                                    <button type="button" class="message-form__button cancel-edit" data-id="{{ $message->id }}">キャンセル</button>
                                </div>
                            </form>
                        </div>

                        {{-- 削除フォーム --}}
                        <form id="delete-{{ $message->id }}" method="POST" action="{{ route('transactions.messages.destroy', $message) }}">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                @endif
            @endforeach
        </div>

        <div class="create-form__wrap">
            @if (! session()->has('updated_message_id') && $errors->default->any())
            <div class="form__error">
                @foreach ($errors->all() as $error)
                    <p class="form__error-message">{{ $error }}</p>
                @endforeach
            </div>
            @endif
            <form method="POST"
                action="{{ route('transactions.messages.store', $transaction) }}"
                enctype="multipart/form-data"
                class="message-form__create">
                @csrf
                <textarea id="transaction-message-create" name="new_message" class="create-form__input  auto-resize" placeholder="取引メッセージを記入してください">{{ old('new_message') }}</textarea>
                <div class="create-form__actions">
                    <label class="image-upload">
                        画像を追加
                        <input type="file" name="image" hidden>
                    </label>
                    <button type="submit" class="create__button"></button>
                </div>
            </form>
        </div>
    </div>
</div>
@if ($transaction->status === 'awaiting_review')
    @if (! $transaction->hasReviewed(auth()->user()))
        @include('transactions.review_modal')
    @else
        @include('transactions.awaiting_seller_review_modal')
    @endif
@endif
<script>
window.transactionConfig = {
    updatedMessageId: @json(session('updated_message_id')),
    lastMessageId: @json(session('lastMessageId')),

};
window.transactionId = {{ $transaction->id }};
</script>
<script src="{{ asset('js/transactions/message.js') }}" defer></script>
<script src="{{ asset('js/transactions/review-modal.js') }}"></script>
<script src="{{ asset('js/transactions/draft-storage.js') }}"></script>
@endsection