<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 
        'first_name', 
        'last_name', 
        'email', 
        'phone', 
        'address', 
        'city', 
        'zip', 
        'payment_method', 
        'payment_proof',
        'total_price', 
        'status', 
        'tracking_number',
        'coupon_id',
        'discount_amount'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function trackingLogs()
    {
        return $this->hasMany(OrderStatusLog::class)->latest();
    }
}
