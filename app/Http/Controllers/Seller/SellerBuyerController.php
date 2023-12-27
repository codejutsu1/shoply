<?php

namespace App\Http\Controllers\Seller;

use App\Models\Seller;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BuyerCollection;

class SellerBuyerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Seller $seller)
    {
        $buyers = $seller->products()
                        ->whereHas('transactions')
                        ->with('transactions.buyer')
                        ->get()
                        ->pluck('transactions')
                        ->collapse()
                        ->pluck('buyer')
                        ->unique('id')
                        ->values();

        return $this->success(new BuyerCollection($buyers));
    }
}
