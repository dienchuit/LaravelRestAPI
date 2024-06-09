<?php

namespace App\Http\Controllers\Buyer;

use App\Models\Buyer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\ApiController;

class BuyerController extends ApiController
{

    
    public function index()
    {
        $buyers = Buyer::get();
        return $this->showAll($buyers);
    }

    

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Buyer $buyer)
    {        
        Gate::authorize('view', $buyer);
        return $this->showOne($buyer);
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
