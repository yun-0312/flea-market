<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'brand',
        'description',
        'price',
        'status',
        'category_id',
        'condition_id',
        'user_id',
        'address_id',
    ];

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function condition() {
        return $this->belongsTo(Condition::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address() {
        return $this->belongsTo(Address::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function likes() {
        return $this->hasMany(Like::class);
    }

    public function likedUsers() {
        return $this->belongsToMany(User::class, 'likes')->withTimestamps();
    }

    public function images() {
        return $this->morphMany(Image::class, 'imageable');
    }
}
