<?php

namespace App\Http\Controllers\Buyer;

use App\Models\Buyer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SellerCollection;

class BuyerSellerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Buyer $buyer)
    {
        $sellers = $buyer->transactions()->with('product.seller')
                        ->get()
                        ->pluck('product.seller')
                        ->unique('id')
                        ->values();

        return $this->success(new SellerCollection($sellers));
    }
}
