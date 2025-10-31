@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}" />
@endsection

@section('header')
        @include('layouts.header')
@endsection

@section('content')
    <div class="content-wrapper">
        <h2 class="register-form__hedding">会員登録</h2>
    </div>
    
@endsection
