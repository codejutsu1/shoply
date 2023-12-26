<?php

namespace App\Models;

use App\Models\User;
use App\Models\Product;
use App\Models\Scopes\SellerScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Seller extends User
{
    use HasFactory;

    protected static function booted(): void
    {
        static::addGlobalScope(new SellerScope);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
