<?php

namespace App\Http\Controllers\Product;

use App\Models\Buyer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ApiController;
use App\Transformers\TransactionTransformer;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class ProductBuyerTransactionController extends ApiController implements HasMiddleware
{

    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            new Middleware('transforminput:'. TransactionTransformer::class, only: ['store','update']),
        ];
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Product $product, Buyer $buyer)
    {
        if ($product->seller_id === $buyer->id) {
            return $this->errorResponse('Buyer must be different from seller', 409);
        }
        if (!$product->isAvailable) {
            return $this->errorResponse('Product must be availble', 409);
        }

        if ($product->quantity < $request->quantity) {
            return $this->errorResponse('Product does not have enough quantity', 409);
        }

        $transactionModel = DB::transaction(function () use ($request, $product, $buyer) {
            $product->quantity -= $request->quantity;
            $product->save();

            $transaction = $buyer->transactions()->create([
                'quantity' => $request->quantity,
                'product_id' => $product->id,
            ]);

            return $transaction;
        });
        return $this->showOne($transactionModel, 201);
    }
}
