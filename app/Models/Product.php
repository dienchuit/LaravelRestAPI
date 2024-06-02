<?php

namespace App\Models;

use Faker\Guesser\Name;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    const AVAILABLE_PRODUCT = 'available';
    const UNAVAILABLE_PRODUCT = 'unavailable';

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['isAvailable'];
    
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
}
