<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Resources\TransactionResource;
use App\Http\Resources\TransactionCollection;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Transaction::all();

        return $this->success(new TransactionCollection($transactions));
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        return $this->success(new TransactionResource($transaction));
    }
}
