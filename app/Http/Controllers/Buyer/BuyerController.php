<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Buyer;
use Illuminate\Http\Request;

class BuyerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $buyers = Buyer::has('transactions')->get();
        return response()->json(['data' => $buyers], 200);
    }

    

    /**
     * Display the specified resource.
     */
    public function show(Buyer $buyer)
    {
        dd($buyer->load('transactions'));die;
        if($buyer->transactions->isEmpty()){
            return response()->json([
                'error' => 'Is not Buyer',
                'code' => 409
            ], 409);
        }
        return response()->json(['data' => $buyer], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
