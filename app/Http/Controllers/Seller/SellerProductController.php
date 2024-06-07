<?php

namespace App\Http\Controllers\Seller;

use App\Models\Seller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\ApiController;
use App\Transformers\ProductTransformer;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class SellerProductController extends ApiController implements HasMiddleware
{

    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            new Middleware('transforminput:'. ProductTransformer::class, only: ['store','update']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Seller $seller)
    {
        $products = $seller->products;
        return $this->showAll($products);
    }


    public function store(Request $request, Seller $seller)
    {
        $product = $seller->products()->create(
            $request->validate([
                'name' => 'required',
                'description' => 'required',
                'quantity' => 'required|integer|min:1|max:150',
                'image' => 'required|image',
            ])
        );
        $product->status = Product::UNAVAILABLE_PRODUCT;
        $product->image = $request->image->store('');
        $product->save();

        return $this->showOne($product, 201);
    }

    public function update(Request $request, Seller $seller, Product $product)
    {        
        $product->update(
            $request->validate([
                'status' => Rule::in([Product::UNAVAILABLE_PRODUCT, Product::AVAILABLE_PRODUCT]),
                'quantity' => 'integer|min:1|max:150',
                'image' => 'image',
            ])
        );
        
        $this->checkSeller($seller, $product);
       

        if ($request->has('status')) {
            $product->status = $request->status;

            if ($product->isAvailable && $product->categories->isEmpty()) {
                return $this->errorResponse('An active product must have at least one category', 409);
            }
        }

        if ($request->has('name')) {
            $product->name = $request->name;
        }

        if ($request->has('image')) {
            Storage::delete($product->image);
            $product->image = $request->image->store('');
            $product->name = $request->name;
        }

        $product->save();
        return $this->showOne($product);
    }

    public function destroy(Seller $seller, Product $product) 
    {
        $this->checkSeller($seller, $product);
        $product->delete();
        Storage::delete($product->image);
        return $this->showOne($product);
    }

    protected function checkSeller($seller, $product)
    {
        if ($seller->id != $product->seller_id) {
            throw new HttpException(433,'Error Processing Request');
        }
    }
}
