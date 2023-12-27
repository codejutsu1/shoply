<?php

namespace App\Http\Controllers\Seller;

use App\Models\Seller;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SellerCollection;

class SellerTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Seller $seller)
    {
        $transactions = $seller->products()
                                ->whereHas('transactions')
                                ->with('transactions')
                                ->get()
                                ->pluck('transactions')
                                ->collapse();

        return $this->success(new SellerCollection($transactions));
    }
}
