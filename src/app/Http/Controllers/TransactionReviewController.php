<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Http\Requests\ReviewRequest;
use App\Models\Review;
use App\Models\Transaction;
use App\Mail\SellerReviewRequestMail;

class TransactionReviewController extends Controller
{
    public function store (ReviewRequest $request, Transaction $transaction) {
        $user = auth()->user();

        if ($transaction->hasReviewed($user)) {
            abort(403);
        }
        Review::create([
            'transaction_id' => $transaction->id,
            'reviewer_id' => $user->id,
            'reviewee_id' => $transaction->partnerUser($user)->id,
            'rating' => $request->rating,
        ]);
        if ($transaction->isBuyer($user)) {
            Mail::to($transaction->seller()->email)
                ->send(new SellerReviewRequestMail($transaction));
        }
        // 両者評価完了チェック
        $reviewerIds = $transaction->reviews()->pluck('reviewer_id');

        if (
            $reviewerIds->contains($transaction->buyer()->id) &&
            $reviewerIds->contains($transaction->seller()->id)
        ) {
            $transaction->update(['status' => 'completed']);
        }
        return redirect()->route('items.index')->with('reviewed', true);
    }
}
