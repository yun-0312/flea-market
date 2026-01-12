<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'item_id',
        'shipping_address_id',
        'payment_method',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function item() {
        return $this->belongsTo(Item::class);
    }

    public function shippingAddress() {
        return $this->belongsTo(ShippingAddress::class);
    }

    public function buyer() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function transaction() {
        return $this->hasOne(Transaction::class);
    }

    //支払い方法の日本語化
    public function getPaymentMethodLabelAttribute()
    {
        return match ($this->payment_method) {
            1 => 'コンビニ支払い',
            2 => 'カード支払い',
        };
    }
}