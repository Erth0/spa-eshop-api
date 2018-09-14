<?php

namespace App\Models\Traits;

use App\Cart\Money;

trait HasPrice
{
    public function getPriceAttribute($value)
    {
        return new Money($value);
    }

    public function getformattedPriceAttribute()
    {
        return $this->price->formatted();
    }
}