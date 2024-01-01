<?php

namespace App\Http\Controllers\Buyer;

use App\Models\Buyer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryCollection;

class BuyerCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Buyer $buyer)
    {
        $categories = $buyer->transactions()->with('product.categories')
                            ->get()
                            ->pluck('product.categories')
                            ->collapse()
                            ->unique()
                            ->values();

        return $this->success(new CategoryCollection($categories));
    }
}
