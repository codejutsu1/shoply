<?php

namespace App\Http\Controllers\Seller;

use App\Models\Seller;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SellerResource;
use App\Http\Resources\SellerCollection;

class SellerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sellers = Seller::has('products')->get();

        return $this->success(new SellerCollection($sellers));
    }
    /**
     * Display the specified resource.
     */
    public function show(Seller $seller)
    {
        // $seller = Seller::has('products')->findOrFail($id);

        return $this->success(new SellerResource($seller));
    }
}
