@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}" />
@endsection

@section('header')
@include('layouts.header_item')
@endsection

@section('content')
<div class="content__link">
    <a href="" class="content-link__item">おすすめ</a>
    <a href="" class="content-link__item">マイリスト</a>
</div>
<div class="items">
    <div class="items__card">
        <img src="{{ asset('storage/images/items/Armani+Mens+Clock.jpg') }}" alt="商品画像" class="items__image">
        <p class="items__name">時計</p>
    </div>
    <div class="items__card">
        <img src="{{ asset('storage/images/items/HDD+Hard+Disk.jpg') }}" alt="item image" class="items__image">
        <p class="items__name">HDD</p>
    </div>
    <div class="items__card">
        <img src="{{ asset('storage/images/items/iLoveIMG+d.jpg') }}" alt="item image" class="items__image">
        <p class="items__name">玉ねぎ</p>
    </div>
    <div class="items__card">
        <img src="{{ asset('storage/images/items/Leather+Shoes+Product+Photo.jpg') }}" alt="item image" class="items__image">
        <p class="items__name">革靴</p>
    </div>
    <div class="items__card">
        <img src="{{ asset('storage/images/items/Living+Room+Laptop.jpg') }}" alt="item image" class="items__image">
        <p class="items__name">ノートPC</p>
    </div>
    <div class="items__card">
        <img src="{{ asset('storage/images/items/Music+Mic+4632231.jpg') }}" alt="item image" class="items__image">
        <p class="items__name">マイク</p>
    </div>
    <div class="items__card">
        <img src="{{ asset('storage/images/items/Purse+fashion+pocket.jpg') }}" alt="item image" class="items__image">
        <p class="items__name">バッグ</p>
    </div>
    <div class="items__card">
        <img src="{{ asset('storage/images/items/Tumbler+souvenir.jpg') }}" alt="item image" class="items__image">
        <p class="items__name">タンブラー</p>
    </div>
    <div class="items__card">
        <img src="{{ asset('storage/images/items/Waitress+with+Coffee+Grinder.jpg') }}" alt="item image" class="items__image">
        <p class="items__name">コーヒーミル</p>
    </div>
    <div class="items__card">
        <img src="{{ asset('storage/images/items/外出メイクアップセット.jpg') }}" alt="item image" class="items__image">
        <p class="items__name">メイクアップセット</p>
    </div>
</div>
@endsection