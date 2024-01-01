<?php

namespace App\Http\Controllers\Product;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BuyerCollection;

class ProductBuyerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Product $product)
    {
        $buyers = $product->transactions()
                            ->with('buyer')
                            ->get()
                            ->pluck('buyer')
                            ->unique('id')
                            ->values();

        return $this->success(new BuyerCollection($buyers));

    }
}
