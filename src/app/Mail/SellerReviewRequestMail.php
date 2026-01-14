<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;

class SellerReviewRequestMail extends Mailable
{

    use Queueable, SerializesModels;

    public Transaction $transaction;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
        $this->seller = $transaction->seller;
        $this->item = $transaction->item;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('購入者からの取引完了の連絡があります')
            ->view('emails.seller_review_request')
            ->with([
                'transaction' => $this->transaction,
                'seller'      => $this->transaction->seller,
                'item'        => $this->transaction->purchase->item,
            ]);
    }
}