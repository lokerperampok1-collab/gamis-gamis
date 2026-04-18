<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'type',
        'value',
        'min_spend',
        'expires_at',
        'usage_limit',
        'used_count'
    ];

    protected $casts = [
        'expires_at' => 'date',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function isValid($cartTotal = 0)
    {
        if ($this->expires_at && $this->expires_at->isPast()) {
            return false;
        }

        if ($this->usage_limit && $this->used_count >= $this->usage_limit) {
            return false;
        }

        if ($this->min_spend && $cartTotal < $this->min_spend) {
            return false;
        }

        return true;
    }

    public function calculateDiscount($cartTotal)
    {
        if (!$this->isValid($cartTotal)) {
            return 0;
        }

        if ($this->type == 'fixed') {
            return min($this->value, $cartTotal);
        } else {
            return ($cartTotal * $this->value) / 100;
        }
    }
}
