<?php

namespace App\Models;

use App\Models\User;
use App\Models\Transaction;
use App\Models\Scopes\BuyerScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Buyer extends User
{
    use HasFactory;

    protected static function booted(): void
    {
        static::addGlobalScope(new BuyerScope);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
