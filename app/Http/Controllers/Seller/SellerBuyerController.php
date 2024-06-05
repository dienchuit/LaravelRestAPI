<?php

namespace App\Http\Controllers\Seller;

use App\Models\Seller;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class SellerBuyerController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Seller $seller)
    {
        $buyers = $seller->products
            ->load('transactions.buyer')
            ->unique('transactions')
            ->pluck('transactions')
            ->collapse()
            ->pluck('buyer')
            ->unique('id');

        return $this->showAll($buyers);
    }
}
