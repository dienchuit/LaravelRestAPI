<?php

namespace App\Models;

use App\Models\Buyer;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Transformers\TransactionTransformer;

class Transaction extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $hidden = [
        'pivot'
    ];

    public $transformer = TransactionTransformer::class;

    protected $fillable = [
        'quantity',
        'buyer_id',
        'product_id',
    ];

    public function buyer() : BelongsTo {
        return $this->belongsTo(Buyer::class, 'buyer_id');
    }

    public function product() : BelongsTo {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
