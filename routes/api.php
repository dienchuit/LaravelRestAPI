<?php

use App\Http\Controllers\Buyer\BuyerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::resource('buyers', BuyerController::class);
