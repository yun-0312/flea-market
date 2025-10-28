<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_code',
        'address',
        'building',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
