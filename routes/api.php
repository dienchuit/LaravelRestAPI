<?php

use App\Http\Controllers\Buyer\BuyerCategoryController;
use App\Http\Controllers\Buyer\BuyerController;
use App\Http\Controllers\Buyer\BuyerProductController;
use App\Http\Controllers\Buyer\BuyerSellerController;
use App\Http\Controllers\Buyer\BuyerTransactionController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Seller\SellerController;
use App\Http\Controllers\Transaction\TransactionCategoryController;
use App\Http\Controllers\Transaction\TransactionController;
use App\Http\Controllers\Transaction\TransactionSellerController;
use App\Http\Controllers\User\UserController;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Buyer
Route::resource('buyers', BuyerController::class)
    ->only(['index', 'show']);
Route::resource('buyers.transactions', BuyerTransactionController::class)
    ->only(['index']);
Route::resource('buyers.products', BuyerProductController::class)
    ->only(['index']);
Route::resource('buyers.sellers', BuyerSellerController::class)
    ->only(['index']);
Route::resource('buyers.categories', BuyerCategoryController::class)
    ->only(['index']);


// Categories
Route::resource('categories', CategoryController::class)
    ->except(['create', 'edit']);

// Products
Route::resource('products', ProductController::class)
    ->only(['index', 'show']);

// Sellers
Route::resource('sellers', SellerController::class)
    ->only(['index', 'show']);

// Transactions
Route::resource('transactions', TransactionController::class)
    ->only(['index', 'show']);

// TransactionCategory
Route::resource('transactions.categories', TransactionCategoryController::class)
    ->only(['index']);

// TransactionSeller
Route::resource('transactions.sellers', TransactionSellerController::class)
    ->only(['index']);

// Category
Route::resource('users', UserController::class)
    ->except(['create', 'edit']);
