@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/verify-email.css') }}" />
@endsection

@section('header')
@include('layouts.header')
@endsection

@section('content')
<div class="container">
    <p class="verify__message">
        登録していただいたメールアドレスに認証メールを送付しました。<br>
        メール認証を完了してください。
    </p>
    <form class="verify__form" method="post" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="verify__button">認証はこちらから</button>
    </form>
    <a href="{{ route('verification.send') }}" class="verify__resend">
        認証メールを再送する
    </a>
</div>
@endsection