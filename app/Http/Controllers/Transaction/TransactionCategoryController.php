<?php

namespace App\Http\Controllers\Transaction;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryCollection;

class TransactionCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum', ['only' => ['index']]);
    }
    
    public function index(Transaction $transaction)
    {
        $categories = $transaction->product->categories;

        return $this->success(new CategoryCollection($categories));
    }
}
