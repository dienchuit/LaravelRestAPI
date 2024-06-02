<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Seller extends User
{
    use HasFactory;

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'seller_id');
    }
}
