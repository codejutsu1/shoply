<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;

class SellerController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sellers = Seller::has('products')->get();

        return $this->success($sellers);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $seller = Seller::has('products')->findOrFail($id);

        return $this->success($seller);
    }
}
