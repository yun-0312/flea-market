@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}" />
@endsection

@section('header')
@include('layouts.header_item')
@endsection

@section('content')
    @if (session('error'))
        <p class="alert-danger">
            {{ session('error') }}
        </p>
    @endif
<div class="content__link">
    <a href="/?tab=recommend" class="content-link__item {{ $tab === 'recommend' ? 'active' : '' }}">おすすめ</a>
    <a href="?tab=mylist" class="content-link__item {{ $tab === 'mylist' ? 'active' : '' }}">マイリスト</a>
</div>
<div class="items">
    @foreach($items as $item)
    <a href="{{ route('item.show', ['item' => $item->id]) }}" class="items__card-link">
        <div class="items__card">
            <img src="{{ asset('storage/images/items/' . $item['image_url']) }}" alt="商品画像" class="items__image">
            <p class="items__name">
                {{ $item['name'] }}
                @if ($item->is_sold)
                <span class="sold__label">sold</span>
                @endif
            </p>
        </div>
    </a>
    @endforeach
</div>
@endsection