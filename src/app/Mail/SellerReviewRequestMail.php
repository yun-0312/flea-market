<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use App\Models\Transaction;

class SellerReviewRequestMail extends Mailable
{

    public Transaction $transaction;
    public $seller;
    public $item;
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
            ->view('emails.seller_review_request');
    }
}