<?php

namespace App\Http\Controllers\Product;

use App\Models\User;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Http\Requests\StoreProductBuyerTransactionRequest;

class ProductBuyerTransactionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductBuyerTransactionRequest $request, Product $product, User $buyer)
    {
        if($buyer->id == $product->seller_id)
        {
            return $this->error('The buyer must be different from the seller', 409);
        }

        if(!$buyer->isVerified())
        {
            return $this->error('The buyer must be a verified user.', 409);
        }

        if(!$product->seller->isVerified())
        {
            return $this->error('The seller must be a verified user.', 409);
        }

        if(!$product->isAvailable())
        {
            return $this->error('The product is not available.', 409);
        }

        if($product->quantity < $request->quantity)
        {
            return $this->error('The product do not have enough units for this transaction.', 409);
        }

        return DB::transaction(function() use ($request, $product, $buyer){
            $product->quantity -= $request->quantity;
            $product->save();

            $transaction = Transaction::create([
                'quantity' => $request->quantity,
                'buyer_id' => $buyer->id,
                'product_id' => $product->id
            ]);

            return $this->success(new TransactionResource($transaction));
        });
    }

    
}
