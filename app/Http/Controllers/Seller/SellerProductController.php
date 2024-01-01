<?php

namespace App\Http\Controllers\Seller;

use App\Models\User;
use App\Models\Seller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\ProductCollection;
use App\Http\Requests\StoreSellerProductRequest;
use App\Http\Requests\UpdateSellerProductRequest;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SellerProductController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('transform.input:' . ProductCollection::class)->only(['store', 'update']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Seller $seller)
    {
        $products = $seller->products;

        return (new ProductCollection($products));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSellerProductRequest $request, User $seller)
    {
        $validated = $request->validated();

        $validated['status'] = Product::UNAVAILABLE_PRODUCT;
        $validated['image'] = $request->image->store();
        $validated['seller_id'] = $seller->id;

        $products = Product::create($validated);

        return $this->success(new ProductResource($products), 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSellerProductRequest $request, Seller $seller, Product $product)
    {
        $validated = $request->validated();

        $this->checkSeller($seller, $product);
        
        if($request->has('status'))
        {
            if($product->isAvailable() && $product->categories()->count() == 0)
            {
                return $this->error('An active product should have at least one category', 409);
            }
        }

        if($request->has('image')){
            Storage::delete($product->image);

            $validated['image'] = $request->image->store();
        }

        $product->update($validated);

        return $this->success(new ProductResource($product));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Seller $seller, Product $product)
    {
        $this->checkSeller($seller, $product);

        $product->delete();

        Storage::delete($product->image);

        return $this->success(new ProductResource($product));
    }

    protected function checkSeller($seller, $product)
    {
        if($seller->id != $product->seller->id)
        {
            throw new HttpException(422, "The specified seller is not the actual seller of the product.");
        }
    }
}
