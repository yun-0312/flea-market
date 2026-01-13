{{-- 背景オーバーレイ --}}
<div id="modal-overlay" class="modal-overlay"></div>

{{-- レビューモーダル --}}
<div id="review-modal" class="review-modal">
    <h2 class="review-modal__title">取引が完了しました。</h2>
    <p class="review-modal__text">
        今回の取引相手はどうでしたか？
    </p>

    <form method="POST" action="{{ route('transactions.reviews.store', $transaction) }}">
        @csrf

        <div class="review-stars">
            @for ($i = 5; $i >= 1; $i--)
                <input
                    type="radio"
                    id="star{{ $transaction->id }}-{{ $i }}"
                    name="rating"
                    value="{{ $i }}"
                >
                <label for="star{{ $transaction->id }}-{{ $i }}"></label>
            @endfor
        </div>

        <button type="submit" class="review-submit">
            送信する
        </button>
    </form>
</div>