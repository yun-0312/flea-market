<?php

namespace App\Http\Controllers;

use App\Models\Transaction;

class TransactionController extends Controller
{
    public function show (Transaction $transaction) {
        $user = auth()->user();
        if (! $transaction->isParticipant($user->id)) {
            abort(403);
        }
        $transaction->load([
            'purchase.user',
            'purchase.user.profile',
            'purchase.item',
            'purchase.item.user',
            'purchase.item.user.profile',
            'messages.sender',
            'messages.sender.profile',
        ]);
        $partner = $transaction->partnerUser($user);
        $messages = $transaction->messages()
            ->whereNull('deleted_at')
            ->oldest()
            ->get();
        $this->markAsRead($transaction, $user->id);
        $sidebarTransactions = Transaction::activeForUserWithUnreadCount($user->id)
            ->where('id', '!=', $transaction->id)
            ->with('purchase.item')
            ->get();
        return view('transaction', compact('user', 'partner', 'transaction', 'messages', 'sidebarTransactions'));
    }

    private function markAsRead (Transaction $transaction, int $userId): void {
        $unreadMessages = $transaction->messages()
            ->where('user_id', '!=', $userId)
            ->whereDoesntHave('reads', fn ($q) => $q->where('user_id', $userId))
            ->get();
        foreach ($unreadMessages as $message) {
            $message->reads()->create([
                'user_id' => $userId,
                'read_at' => now(),
            ]);
        }
    }

    public function complete (Transaction $transaction) {
        $user = auth()->user();
        abort_unless($transaction->isBuyer($user), 403);
        $transaction->update([
            'status' => 'awaiting_review',
        ]);
        return redirect()->route('transactions.show', $transaction);
    }
}