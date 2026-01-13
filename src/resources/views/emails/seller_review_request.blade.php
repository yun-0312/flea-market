<!DOCTYPE html>
<html>
    <body>
        <p>{{ $seller->name }} 様</p>

        <p>
            商品「{{ $item->name }}」の取引が完了しました。<br>
            取引画面から購入者の評価をお願いします。
        </p>

        <p>
            <a href="{{ route('transactions.show', $transaction) }}">
                取引画面を開く
            </a>
        </p>
    </body>
</html>