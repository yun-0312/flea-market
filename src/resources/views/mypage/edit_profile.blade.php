@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/edit_profile.css') }}">
@endsection

@section('header')
@include('layouts.header_item')
@endsection

@section('content')
<div class="content-wrapper">
    @if (session('success'))
    <p class="alert">
        {{ session('success') }}
    </p>
    @endif
    <h2 class="edit-profile-form__heading">プロフィール設定</h2>
    <form class="form" action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="edit-profile-form__image-section">
            <div class="edit-profile-form__image-circle">
                {{-- プロフィール画像がある場合は表示 --}}
                @if($profile->image_url)
                <img src="{{ asset('storage/images/profiles/' . $profile->image_url) }}" alt="プロフィール画像" class="edit-profile-form__image-preview">
                @else
                <div class="edit-profile-form__image-placeholder"></div>
                @endif
            </div>
            <label class="edit-profile-form__image-label">
                画像を選択する
                <input type="file" name="image_url" class="edit-profile-form__image-input" hidden>
            </label>
        </div>
        <div class="edit-profile-form__group">
            <label class="edit-profile-form__label" for="name">ユーザー名</label>
            <input type="text" id="name" class="edit-profile-form__input" name="name" value="{{ old('name', auth()->user()->name) }}">
            @error('name')
            <p class="edit-profile-form__error-message">
                {{ $message }}
            </p>
            @enderror
        </div>
        <div class="edit-profile-form__group">
            <label class="edit-profile-form__label" for="post_code">郵便番号</label>
            <input type="text" id="post_code" class="edit-profile-form__input" name="post_code" value="{{ old('post_code', $profile->post_code ?? '') }}">
            @error('post_code')
            <p class="edit-profile-form__error-message">
                {{ $message }}
            </p>
            @enderror
        </div>
        <div class="edit-profile-form__group">
            <label class="edit-profile-form__label" for="address">住所</label>
            <input type="text" id="address" class="edit-profile-form__input" name="address" value="{{ old('address', $profile->address ?? '') }}">
            @error('address')
            <p class="edit-profile-form__error-message">
                {{ $message }}
            </p>
            @enderror
        </div>
        <div class="edit-profile-form__group">
            <label class="edit-profile-form__label" for="building">建物名</label>
            <input type="text" id="building" class="edit-profile-form__input" name="building" value="{{ old('building', $profile->building ?? '') }}">
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.querySelector('.edit-profile-form__image-input');
        const previewImage = document.querySelector('.edit-profile-form__image-preview');
        const placeholder = document.querySelector('.edit-profile-form__image-placeholder');
        const imageCircle = document.querySelector('.edit-profile-form__image-circle');

        fileInput.addEventListener('change', function(event) {
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // 既にプレビュー画像がある場合はそれを使う
                    if (previewImage) {
                        previewImage.src = e.target.result;
                        previewImage.style.display = 'block';
                    } else {
                        // 初めて選択された場合は新しくimg要素を追加
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.alt = 'プロフィール画像プレビュー';
                        img.classList.add('edit-profile-form__image-preview');
                        imageCircle.innerHTML = ''; // プレースホルダー削除
                        imageCircle.appendChild(img);
                    }

                    // プレースホルダーは非表示
                    if (placeholder) placeholder.style.display = 'none';
                };
                reader.readAsDataURL(file);
            } else {
                // ファイル選択を取り消した場合
                if (previewImage) {
                    previewImage.style.display = 'none';
                }
                if (placeholder) {
                    placeholder.style.display = 'block';
                }
            }
        });
    });
</script>
@endsection