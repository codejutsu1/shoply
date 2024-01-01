<?php

namespace App\Http\Controllers\Buyer;

use App\Models\Buyer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionCollection;

class BuyerTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Buyer $buyer)
    {
        $transactions = $buyer->transactions;

        return $this->success(new TransactionCollection($transactions));
    }
}
