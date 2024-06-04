<?php

namespace App\Models;

use App\Models\Seller;
use Faker\Guesser\Name;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    use HasFactory;
    const AVAILABLE_PRODUCT = 'available';
    const UNAVAILABLE_PRODUCT = 'unavailable';

    // Note: using snake case 
    protected $appends = [
        'is_available'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    
    protected $fillable = [
        'name',
        'description',
        'quantity',
        'status',
        'image',
        'seller_id'
    ];

    /**
     * Determine if the user is Available
     */
    protected function isAvailable(): Attribute
    {
        return new Attribute(
            get: fn () =>  $this->status == Product::AVAILABLE_PRODUCT
        );
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_id');
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class, 'seller_id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
