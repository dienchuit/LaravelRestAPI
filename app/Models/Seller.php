<?php

namespace App\Models;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Scopes\SellerScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;

#[ScopedBy([SellerScope::class])]
class Seller extends User
{
    use HasFactory;

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'seller_id');
    }
}
