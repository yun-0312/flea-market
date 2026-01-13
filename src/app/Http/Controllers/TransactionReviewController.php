<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ReviewRequest;
use App\Models\Review;
use App\Models\Transaction;

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
            'comment' => $request->comment,
        ]);
        return redirect()->route('items.index')->with('reviwed', true);
    }
}
