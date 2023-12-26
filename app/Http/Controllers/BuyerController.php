<?php

namespace App\Http\Controllers;

use App\Models\Buyer;
use Illuminate\Http\Request;
use App\Http\Resources\BuyerResource;
use App\Http\Resources\BuyerCollection;

class BuyerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $buyers = Buyer::has('transactions')->get();

        return $this->success(new BuyerCollection($buyers));
    }

    /**
     * Display the specified resource.
     */
    public function show(Buyer $buyer)
    {
        return $this->success(new BuyerResource($buyer));
    }
}
