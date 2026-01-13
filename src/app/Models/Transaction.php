<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_id',
        'status',
    ];

    public function purchase() {
        return $this->belongsTo(Purchase::class);
    }


    public function messages() {
        return $this->hasMany(TransactionMessage::class);
    }

    public function latestMessage() {
        return $this->hasOne(TransactionMessage::class)->latestOfMany();
    }

    public function reviews() {
        return $this->hasMany(Review::class);
    }

        public function buyer(): \App\Models\User
    {
        return $this->purchase->user;
    }

    public function seller(): \App\Models\User
    {
        return $this->purchase->item->user;
    }

    public function hasReviewed(User $user): bool {
        return $this->reviews()
            ->where('reviewer_id', $user->id)
            ->exists();
    }

    public function scopeActiveForUserWithUnreadCount($query, int $userId)
    {
        return $query
            ->whereIn('status', ['trading', 'awaiting_review'])
            ->whereHas('purchase', function ($q) use ($userId) {
                $q->where('user_id', $userId) // buyer
                ->orWhereHas('item', function ($q) use ($userId) {
                    $q->where('user_id', $userId); // seller
                });
            })
            ->withCount(['messages as unread_count' => function ($q) use ($userId) {
                $q->where('user_id', '!=', $userId) // sender
                    ->whereDoesntHave('reads', function ($q) use ($userId) {
                        $q->where('user_id', $userId);
                    })
                    ->whereNull('deleted_at');
            }])
            ->orderByDesc(
                TransactionMessage::select('created_at')
                    ->whereColumn('transaction_id', 'transactions.id')
                    ->whereNull('deleted_at')
                    ->limit(1)
            );
    }

    public function isParticipant (int $userId) : bool {
        return $this->purchase->user_id === $userId
            || $this->purchase->item->user_id === $userId;
    }

    public function isBuyer(User $user): bool {
        return $this->purchase->user_id === $user->id;
    }

    public function partnerUser(User $user): User {
        if ($this->purchase->user_id === $user->id) {
            return $this->purchase->item->user;
        }
        return $this->purchase->user;
    }
}