<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['category_id', 'name', 'slug', 'description', 'price', 'original_price', 'stock', 'image'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?: 0;
    }

    public function wishlistedBy()
    {
        return $this->hasMany(Wishlist::class);
    }
}
