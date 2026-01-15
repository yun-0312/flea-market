<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionMessage;
use App\Http\Requests\TransactionMessageRequest;
use App\Http\Requests\UpdateTransactionMessageRequest;
use Illuminate\Support\Facades\Storage;

class TransactionMessageController extends Controller
{
    public function store (TransactionMessageRequest $request, Transaction $transaction) {
        if (! $transaction->isParticipant(auth()->id()) || $transaction->status !== 'trading') {
            abort(403);
        }
        $path = null;
        if ($request->hasFile('image')) {
            $storePath = $request->file('image')->store('public/images/transaction_messages');
            $path = basename($storePath);
        }
        $message = TransactionMessage::create([
            'transaction_id' => $transaction->id,
            'user_id' => auth()->id(),
            'message' => $request->new_message,
            'image_url' => $path,
        ]);
        return redirect()
            ->route('transactions.show', $transaction)
            ->with('lastMessageId', $message->id);
    }

    public function update(UpdateTransactionMessageRequest $request, TransactionMessage $message) {
        if ($message->user_id !== auth()->id()) {
            abort(403);
        }
        $message->message = $request->message;
        if ($request->hasFile('image')) {
            if ($message->image_url) {
                Storage::disk('public')->delete(
                    'images/transaction_messages/' . $message->image_url
                );
            }
            $path = $request->file('image')->store('images/transaction_messages' , 'public');
            $message->image_url = basename($path);
        } elseif ($request->boolean('remove_image')) {
            if ($message->image_url) {
                Storage::disk('public')->delete(
                    'images/transaction_messages/' . $message->image_url
                );
                $message->image_url = null;
            }
        }
        $message->save();
        return back();
    }

    public function destroy(TransactionMessage $message) {
        if ($message->user_id !== auth()->id()) {
            abort(403);
        }

        $message->delete();

        return back();
    }
}