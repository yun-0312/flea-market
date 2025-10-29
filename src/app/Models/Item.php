<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id'
        'name',
        'brand',
        'description',
        'price',
        'image_url',
        'condition',
    ];

    public function categories() {
        return $this->belongsToMany(Category::class, 'product_category');
    }

    public function user() {
        return $this->belongsTo(User::class);
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
}
