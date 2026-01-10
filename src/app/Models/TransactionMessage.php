<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionMessage extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'transaction_id',
        'user_id',
        'message',
        'image_url',
    ];

    public function transaction() {
        return $this->belongsTo(Transaction::class);
    }

    public function sender() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function reads() {
        return $this->hasMany(TransactionMessageRead::class);
    }

    public function isUnreadBy($userId) {
        return !$this->reads()->where('user_id', $userId)->exists();
    }
}