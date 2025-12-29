<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'category_id', 'category', 'price', 'stock', 'image',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function averageRating()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    public function reviewCount()
    {
        return $this->reviews()->count();
    }

    protected static function booted()
    {
        static::saving(function ($product) {
            // Keep the denormalized `category` string column in sync with `category_id`
            if ($product->category_id) {
                if ($product->relationLoaded('category') && $product->category) {
                    $product->category = $product->category->name;
                } else {
                    $cat = \App\Models\Category::find($product->category_id);
                    $product->category = $cat ? $cat->name : null;
                }
            } else {
                $product->category = null;
            }
        });
    }
}

