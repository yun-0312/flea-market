<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Purchase;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'brand',
        'description',
        'price',
        'image_url',
        'condition',
    ];

    public function categories() {
        return $this->belongsToMany(Category::class, 'category_item');
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function favoritedBy() {
        return $this->belongsToMany(User::class, 'favorites', 'item_id', 'user_id')->withTimestamps();
    }
    //購入済み表示
    public function getIsSoldAttribute() {
        return Purchase::where('item_id', $this->id)->exists();
    }

    //検索
    public function scopeKeywordSearch($query, $keyword) {
        if (!empty($keyword)) {
            $query->where('name', 'like', '%' . $keyword . '%');
        }
        return $query;
    }

    //コンディションの日本語化
    public function getConditionLabelAttribute() {
        return match($this->condition) {
            1 => '良好',
            2 => '目立った傷や汚れなし',
            3 => 'やや傷や汚れあり',
            4 => '状態が悪い',
        };
    }
}
