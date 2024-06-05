<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Models\Seller;
use Illuminate\Http\Request;

class SellerCategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Seller $seller)
    {
        $categories = $seller->products
            ->load('categories')
            ->unique('categories')
            ->pluck('categories')
            ->collapse();

        return $this->showAll($categories);
    }

    
}
