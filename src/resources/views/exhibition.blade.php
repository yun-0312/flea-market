@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/exhibition.css') }}" />
@endsection

@section('header')
@include('layouts.header_item')
@endsection

@section('content')
<div class="content-wrapper">
    <h2 class="exhibition-form__heading">商品の出品</h2>
    <form class="form" action="{{ route('item.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="exhibition-form__group">
            <label class="exhibition-form__label" for="image_url">商品画像</label>
            <div class="exhibition-form__image-section">
                <div class="exhibition-form__image">
                    <img id="preview" src="" alt="商品画像" class="exhibition-form__image-preview">
                    <button type="button" id="removeImage" class="exhibition-form__remove-btn">&times;</button>
                </div>
                <label class="exhibition-form__image-label">
                    画像を選択する
                    <input type="file" name="image_url" id="image_url" class="exhibition-form__image-input" hidden>
                </label>
            </div>
            @error('image_url')
            <p class="exhibition-form__error-message">
                {{ $message }}
            </p>
            @enderror
        </div>
        <h3 class="exhibition-form__subheading">商品の詳細</h3>
        <div class="exhibition-form__group">
            <label class="exhibition-form__label">カテゴリー</label>
            <div class="exhibition-form__category">
                @foreach($categories as $category)
                <label class="category-button">
                    <input type="checkbox"
                        name="categories[]"
                        value="{{ $category->id }}"
                        {{ (is_array(old('categories')) && in_array($category->id, old('categories'))) ? 'checked' : '' }}>
                    <span>{{ $category->name }}</span>
                </label>
                @endforeach
            </div>
            @error('categories')
            <p class="exhibition-form__error-message">
                {{ $message }}
            </p>
            @enderror
        </div>
        <div class="exhibition-form__group">
            <label class="exhibition-form__label" for="condition">商品の状態</label>
            <select name="condition" id="condition" class="exhibition-form__input">
                <option value="">選択してください</option>
                <option value="1" {{ old('condition') == 1 ? 'selected' : '' }}>良好</option>
                <option value="2" {{ old('condition') == 2 ? 'selected' : '' }}>目立った傷や汚れなし</option>
                <option value="3" {{ old('condition') == 3 ? 'selected' : '' }}>やや傷や汚れあり</option>
                <option value="4" {{ old('condition') == 4 ? 'selected' : '' }}>状態が悪い</option>
            </select>
            @error('condition')
            <p class="exhibition-form__error-message">
                {{ $message }}
            </p>
            @enderror
        </div>
        <h3 class="exhibition-form__subheading">商品名と説明</h3>
        <div class="exhibition-form__group">
            <label class="exhibition-form__label" for="name">商品名</label>
            <input type="text" class="exhibition-form__input" name="name" value="{{ old('name') }}">
            @error('name')
            <p class="exhibition-form__error-message">
                {{ $message }}
            </p>
            @enderror
        </div>
        <div class="exhibition-form__group">
            <label class="exhibition-form__label" for="brand">ブランド名</label>
            <input type="text" class="exhibition-form__input" name="brand" value="{{ old('brand') }}">
            @error('brand')
            <p class="exhibition-form__error-message">
                {{ $message }}
            </p>
            @enderror
        </div>
        <div class="exhibition-form__group">
            <label class="exhibition-form__label" for="description">商品の説明</label>
            <input type="text" class="exhibition-form__input" name="description" value="{{ old('description') }}">
            @error('description')
            <p class="exhibition-form__error-message">
                {{ $message }}
            </p>
            @enderror
        </div>
        <div class="exhibition-form__group">
            <label class="exhibition-form__label" for="price">販売価格</label>
            <input type="number" class="exhibition-form__input" name="price" placeholder="￥" value="{{ old('price') }}">
            @error('price')
            <p class="exhibition-form__error-message">
                {{ $message }}
            </p>
            @enderror
        </div>
        <div class="exhibition-form__group">
            <input type="submit" class="exhibition-form__btn" value="出品する">
        </div>
    </form>
</div>

<!-- 画像プレビュー用スクリプト -->
<script>
    const input = document.querySelector('.exhibition-form__image-input');
    const preview = document.getElementById('preview');
    const label = document.querySelector('.exhibition-form__image-label');
    const imageWrapper = document.querySelector('.exhibition-form__image');
    const removeBtn = document.getElementById('removeImage');

    input.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                preview.src = event.target.result;
                imageWrapper.style.display = 'flex';
                label.style.display = 'none';
                removeBtn.style.display = 'block'; // ×ボタンを表示
            };
            reader.readAsDataURL(file);
        }
    });

    removeBtn.addEventListener('click', function() {
        preview.src = '';
        imageWrapper.style.display = 'none';
        label.style.display = 'flex';
        removeBtn.style.display = 'none';
        input.value = ''; // ファイル選択リセット
    });
</script>
@endsection