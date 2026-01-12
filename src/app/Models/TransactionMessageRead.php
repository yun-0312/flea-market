<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionMessageRead extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_message_id',
        'user_id',
        'read_at',
    ];

    public $timestamps = false;

    public function message() {
        return $this->belongsTo(TransactionMessage::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}