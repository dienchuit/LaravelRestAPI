<?php

namespace App\Models;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Scopes\BuyerScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;

#[ScopedBy([BuyerScope::class])]
class Buyer extends User
{
    use HasFactory;

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'buyer_id');
    }
}
