<div id="modal-overlay" class="modal-overlay"></div>

<div id="review-modal" class="review-modal">
    <h2 class="review-modal__title">取引が完了しました。</h2>

    <p class="review-modal__text">
        今回の取引相手はどうでしたか？
    </p>

    <form method="POST" action="{{ route('transactions.reviews.store', $transaction) }}">
        @csrf

        <input type="hidden" name="rating" id="rating-value" value="3">

        <div class="review-stars" id="review-stars">
            @for ($i = 1; $i <= 5; $i++)
                <button
                    type="button"
                    class="star {{ $i <= 3 ? 'is-active' : '' }}"
                    data-value="{{ $i }}"
                ><img src="{{ asset('/img/Star 6.png') }}" alt="logo" class="header-logo__image"></button>
            @endfor
        </div>

        <button type="submit" class="review-submit">
            送信する
        </button>
    </form>
</div>