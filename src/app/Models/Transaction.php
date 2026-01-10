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

    public function reviews() {
        return $this->hasMany(Review::class);
    }

    public function buyer() {
        return $this->hasOneThrough(
            User::class,
            Purchase::class,
            'id',
            'id',
            'purchase_id',
            'user_id',
        );
    }

    public function seller() {
        return $this->hasOneThrough(
            User::class,
            Purchase::class,
            'id',
            'id',
            'purchase_id',
            'item_id',
        )->join('items', 'items.id', '=', 'purchases.item_id');
    }
}